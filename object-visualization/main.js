const canvas = document.getElementById('myCanvas');
    const ctx = canvas.getContext("2d");
    var x = 200;
    var y = 100;


function fillRectangle(lines, refArray, isOrphaned) {
    console.log("fillRectangle");
    console.log("lines:", lines);
    console.log("references:", refArray);
    console.log("orphaned:", isOrphaned);
    
    // Handle both array and string input for backward compatibility
    var references = Array.isArray(refArray) ? refArray : [refArray];
    isOrphaned = isOrphaned || false;
    
    sblockMidx = 500;
    sblockMidy = 0;
    if (classVariables.length > 0) {
        y_static = 100;
        x_static = sblockMidx;
        maxL = 0;
        for (var i = 0; i < classVariables.length; i++) {
            ctx.font = "20px Arial";
            y_static = y_static + 30;
            line = classVariables[i][0] + " " + classVariables[i][1];
            if (classVariables[i].length > 2) {
                line = line + " = " + classVariables[i][2] + ";";
            }

            if (line.length > maxL) {
                maxL = line.length;
            }
            ctx.fillText(line, x_static, y_static);
        }
        ctx.rect(x_static - 20, 100, 40 + (maxL * 10), y_static - 50);
        ctx.stroke();

        sblockMidy = y_static - 20;
    }

    var yVar = y;
    var height = lines.length * 40;
    var maxStrLen = 0;
    
    // Set color for orphaned objects
    if (isOrphaned) {
        ctx.fillStyle = "#999999"; // Gray text for orphaned
    }
    
    for (var i = 0; i < lines.length; i++) {
        ctx.font = "20px Arial";
        y = y + 30;
        ctx.fillText(lines[i], x, y);
        if (lines[i].length > maxStrLen) {
            maxStrLen = lines[i].length;
        }
    }
    y = y + 60;
    
    // Draw object box (dashed for orphaned)
    if (isOrphaned) {
        ctx.setLineDash([5, 5]); // Dashed line for orphaned
        ctx.strokeStyle = "#999999";
    }
    ctx.rect(x - 20, yVar, 40 + (maxStrLen * 10), height);
    ctx.stroke();
    ctx.setLineDash([]); // Reset to solid line
    ctx.strokeStyle = "#000000";
    ctx.fillStyle = "#000000";

    // Draw all reference arrows pointing to this object
    if (!isOrphaned) {
        ctx.font = "20px Arial";
        
        for (var r = 0; r < references.length; r++) {
            var refName = references[r];
            var refWidth = refName.length * 10;
            var verticalOffset = r * 35; // Offset each reference vertically
            
            // Draw reference name
            ctx.fillStyle = (r > 0) ? "#0052CC" : "#000000"; // Blue for aliases
            ctx.fillText(refName, x - 120 - refWidth, yVar + 50 + verticalOffset);
            
            // Draw arrow
            ctx.beginPath();
            ctx.strokeStyle = (r > 0) ? "#0052CC" : "#000000";
            ctx.lineWidth = (r > 0) ? 2 : 1;
            ctx.moveTo(x - 100, yVar + 50 + verticalOffset);
            ctx.lineTo(x - 20, yVar + 20 + verticalOffset);
            ctx.stroke();
            
            // Reset styles
            ctx.fillStyle = "#000000";
            ctx.strokeStyle = "#000000";
            ctx.lineWidth = 1;
        }
    } else {
        // For orphaned objects, show label without arrow
        ctx.font = "16px Arial";
        ctx.fillStyle = "#999999";
        ctx.fillText("(no references)", x - 120, yVar + 50);
        ctx.fillStyle = "#000000";
    }

    if (sblockMidy != 0) {
        ctx.beginPath();
        ctx.moveTo(x - 20 + 40 + (maxStrLen * 10), yVar + 10);
        ctx.lineTo(sblockMidx - 20, sblockMidy);
        ctx.stroke();
    }

}

var classArr = [];
var classVariables = [];
var instanceVariables = [];



function showMemory() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    x = 200;
    y = 100;

    classArr = [];
    classVariables = [];
    instanceVariables = [];
    var clsTxt = document.getElementById('classarea').value;
    var lines = clsTxt.split("\n");
    var classStartFlag = false;
    var methodStartFlag = false;

    var instanceVariable = [];
    var staticVariable = [];

    for (var x = 0; x < lines.length; x++) {
        var line = lines[x];
        console.log(line);
        if (line.trim()
            .length == 0) {
            continue;
        }


        if (line.trim().startsWith("\/\/")) {
            continue;
        }

        if (classStartFlag) {

            if (methodStartFlag == false) {
                if (line.trim() == "}") {
                    classStartFlag = false;
                    continue;
                }
            } else {
                if (line.trim() == "}") {
                    methodStartFlag = false;
                    continue;
                }
            }

            line = line.replace("=", " = ");
            line = line.replace(";", " ;");
            line = line.replace("  ", " ");
            line = line.replace("  ", " ");
            if (line.includes("static")) {

                vari = [];
                var stxt = line.trim()
                    .split(" ");
                vari.push(stxt[1]);
                vari.push(stxt[2]);

                if (line.includes(" = ")) {
                    vari.push(stxt[4]);
                }
                classVariables.push(vari);
            } else {
                vari = [];
                console.log(line);
                var stxt = line.trim()
                    .split(" ");
                vari.push(stxt[0]);
                vari.push(stxt[1]);
                if (line.includes(" = ")) {
                    vari.push(stxt[3]);
                }
                instanceVariables.push(vari);
            }
        }

        if (line.trim()
            .startsWith("class")) {
            var clsName = line.trim()
                .replace("class", "")
                .replace("{", "")
                .trim();
            classArr.push(clsName);
            if (line.includes("{")) {
                classStartFlag = true;
            }
        }
    }

    console.log(instanceVariables);
    console.log(classVariables);
    console.log(classArr);
    loadObjects();
}

function loadObjects() {
    var refArr = [];
    var refName = [];
    var clsTxt = document.getElementById('codearea')
        .value;
    var lines1 = clsTxt.split("\n");

    for (var x = 0; x < lines1.length; x++) {
        if(document.getElementById('check'+(x+1)).checked == false){
            continue;
        }

        var line = lines1[x].trim();
        console.log("starting for " + line);
        if (line.includes("=")) {
            // assignment happens
            var oparts = line.trim()
                .split("=");
            var leftPart = oparts[0];
            var rightPart = oparts[1];

            var lside = leftPart.trim()
                .split(" ");
            if (lside.length == 1) {
                // Check if this has a dot (property assignment) or not (reference reassignment)
                if (lside[0].includes(".")) {
                    // Property assignment: h1.name = "John"
                    var assignParts = lside[0].split(".");
                    console.log(assignParts);
                    var refVariable = assignParts[0];
                    var variName = assignParts[1];
                    var variValue = rightPart.split(";")[0].trim();
                    console.log(refVariable + " - " + variName +  " - " + variValue);
                    console.log("ML1");
                    console.log(refArr);
                    
                    for (var k = 0; k < refArr.length; k++) {
                        console.log(refArr[k][0] + " - " + refVariable);
                        if (refArr[k][0] == refVariable) {
                            iArr = refArr[k][2];
                            console.log(iArr[k]);
                            for (var k1 = 0; k1 < iArr.length; k1++) {
                                console.log(iArr[k1][1] + " - " + variName);
                                if (iArr[k1][1] == variName) {
                                    console.log("match found " + iArr[k1][1] + " and " + variName);
                                    if (iArr[k1].length > 2) {
                                        iArr[k1][2] = variValue;
                                    } else {
                                        iArr[k1].push(variValue);
                                    }
                                    break;
                                }
                            }
                            break;
                        }
                    }

                    for (var k2 = 0; k2 < classVariables.length; k2++) {
                        if (classVariables[k2][1] == variName) {
                            if (classVariables[k2].length > 2) {
                                classVariables[k2][2] = variValue;
                            } else {
                                classVariables[k2].push(variValue);
                            }
                        }
                    }
                } else {
                    // Reference reassignment: h2 = h1; OR h2 = new Human(); OR h2 = null;
                    var existingRefName = lside[0];
                    var newTargetRef = rightPart.trim().replace(";", "").trim();
                    
                    console.log("Reference reassignment: " + existingRefName + " = " + newTargetRef);
                    
                    // Check if reassigning to NULL
                    if (newTargetRef === "null") {
                        // Reassigning to null: h2 = null;
                        console.log("Reassigning " + existingRefName + " to null");
                        
                        // Find the existing reference and mark it as REMOVED
                        for (var k = 0; k < refArr.length; k++) {
                            if (refArr[k][0] == existingRefName && refArr[k][5] !== "REMOVED") {
                                // Mark this REFERENCE as removed
                                refArr[k][5] = "REMOVED";
                                console.log("Removed reference " + existingRefName + " (set to null)");
                                break;
                            }
                        }
                        // Don't create any new entry - the reference is now null
                        
                    } else if (newTargetRef.startsWith("new ")) {
                        // Extract class name from "new ClassName()"
                        var newClassName = newTargetRef.replace("new ", "").replace("()", "").trim();
                        
                        console.log("Reassigning " + existingRefName + " to new object of type " + newClassName);
                        
                        // Find the existing reference and mark it as REMOVED (not orphaned!)
                        // The object it was pointing to may still have other references
                        for (var k = 0; k < refArr.length; k++) {
                            if (refArr[k][0] == existingRefName) {
                                // Mark this REFERENCE as removed (don't mark object as orphaned)
                                refArr[k][5] = "REMOVED";
                                console.log("Removed old reference entry for " + existingRefName);
                                break;
                            }
                        }
                        
                        // Create a NEW object and make existingRefName point to it
                        var newRef = [];
                        newRef.push(existingRefName);  // [0] Reference name (h2)
                        newRef.push(newClassName);  // [1] Class name
                        newRef.push(clone(instanceVariables));  // [2] New instance variables
                        newRef.push(clone(classVariables));  // [3] Static variables
                        newRef.push(null);  // [4] Not an alias
                        newRef.push(null);  // [5] Not orphaned
                        newRef.push(Date.now() + "_" + Math.random());  // [6] Unique object ID
                        refArr.push(newRef);
                        console.log("Created new object for " + existingRefName);
                        
                    } else {
                        // Reassigning to an existing reference: h2 = h3;
                        
                        // Find the existing reference and mark it as REMOVED (not orphaned!)
                        // The object it was pointing to may still have other references
                        for (var k = 0; k < refArr.length; k++) {
                            if (refArr[k][0] == existingRefName) {
                                // Mark this REFERENCE as removed (don't mark object as orphaned)
                                refArr[k][5] = "REMOVED";
                                console.log("Removed old reference entry for " + existingRefName);
                                break;
                            }
                        }
                        
                        // Find the target object and create a new alias
                        var targetObjectIndex = -1;
                        for (var t = 0; t < refArr.length; t++) {
                            if (refArr[t][0] == newTargetRef && (!refArr[t][5] || refArr[t][5] !== "ORPHANED" && refArr[t][5] !== "REMOVED")) {
                                targetObjectIndex = t;
                                break;
                            }
                        }
                        
                        if (targetObjectIndex >= 0) {
                            // Create new alias reference
                            var aliasRef = [];
                            aliasRef.push(existingRefName);  // [0] Reference name (h2)
                            aliasRef.push(refArr[targetObjectIndex][1]);  // [1] Class name
                            aliasRef.push(refArr[targetObjectIndex][2]);  // [2] SAME instance variables
                            aliasRef.push(refArr[targetObjectIndex][3]);  // [3] SAME static variables
                            aliasRef.push(newTargetRef);  // [4] Points to this reference
                            aliasRef.push(null);  // [5] Not orphaned
                            aliasRef.push(refArr[targetObjectIndex][6]);  // [6] SAME object ID
                            refArr.push(aliasRef);
                            console.log(existingRefName + " now points to " + newTargetRef);
                        }
                    }
                }

            } else {
                var className = lside[0];
                var refVariableName = lside[1];
                var rightPartClean = rightPart.trim().replace(";", "").trim();
                
                // Check if this is a new object creation or reference assignment
                if (rightPart == "null") {
                    // null assignment - don't create object
                    console.log(refVariableName + " assigned to null");
                    
                } else if (rightPartClean.startsWith("new ")) {
                    // New object creation: Human h1 = new Human();
                    var ref = [];
                    refName.push(refVariableName);
                    ref.push(refVariableName);
                    ref.push(className);
                    ref.push(clone(instanceVariables));
                    ref.push(clone(classVariables));
                    ref.push(null);  // [4] Not an alias
                    ref.push(null);  // [5] Not orphaned
                    ref.push(Date.now() + "_" + Math.random());  // [6] Unique object ID
                    refArr.push(ref);
                    console.log("Created new object: " + refVariableName);
                    
                } else {
                    // Reference assignment: Human h2 = h1;
                    // Check if rightPartClean is an existing reference
                    var existingObjectIndex = -1;
                    for (var r = 0; r < refArr.length; r++) {
                        if (refArr[r][0] == rightPartClean) {
                            existingObjectIndex = r;
                            break;
                        }
                    }
                    
                    if (existingObjectIndex >= 0) {
                        // Found existing object - create alias reference
                        var aliasRef = [];
                        aliasRef.push(refVariableName);  // [0] New reference name (e.g., "h2")
                        aliasRef.push(className);  // [1] Class name
                        aliasRef.push(refArr[existingObjectIndex][2]);  // [2] SAME instance variables (not cloned!)
                        aliasRef.push(refArr[existingObjectIndex][3]);  // [3] SAME static variables
                        aliasRef.push(rightPartClean);  // [4] Mark as alias pointing to this reference
                        aliasRef.push(null);  // [5] Not orphaned
                        aliasRef.push(refArr[existingObjectIndex][6]);  // [6] SAME object ID
                        refArr.push(aliasRef);
                        console.log(refVariableName + " points to " + rightPartClean + " (same object)");
                    } else {
                        // Fallback: treat as new object if reference not found
                        var ref = [];
                        refName.push(refVariableName);
                        ref.push(refVariableName);
                        ref.push(className);
                        ref.push(clone(instanceVariables));
                        ref.push(clone(classVariables));
                        ref.push(null);  // [4] Not an alias
                        ref.push(null);  // [5] Not orphaned
                        ref.push(Date.now() + "_" + Math.random());  // [6] Unique object ID
                        refArr.push(ref);
                        console.log("Warning: " + rightPartClean + " not found, creating new object for " + refVariableName);
                    }
                }
            }
        }
    }

    console.log("Final refArr:", refArr);
    
    // Detect objects that have no active references (all references are REMOVED)
    // Group references by object ID
    var objectRefs = new Map(); // Maps objectId to array of indices in refArr
    for (var i = 0; i < refArr.length; i++) {
        var objectId = refArr[i][6];
        if (!objectRefs.has(objectId)) {
            objectRefs.set(objectId, []);
        }
        objectRefs.get(objectId).push(i);
    }
    
    // Check each object to see if all its references are REMOVED
    objectRefs.forEach(function(indices, objectId) {
        var allRemoved = true;
        for (var idx of indices) {
            var status = refArr[idx][5];
            if (status !== "REMOVED" && status !== "ORPHANED") {
                allRemoved = false;
                break;
            }
        }
        
        // If all references are REMOVED, mark one as ORPHANED so it shows up
        if (allRemoved) {
            // Find the first non-ORPHANED entry to mark
            for (var idx of indices) {
                if (refArr[idx][5] === "REMOVED") {
                    refArr[idx][5] = "ORPHANED";
                    console.log("Object " + objectId + " has no active references - marking as ORPHANED");
                    break;
                }
            }
        }
    });
    
    // Track which objects have been drawn and their references
    var drawnObjects = new Map(); // Maps object key to list of active references
    var orphanedObjects = []; // Objects with no references
    
    // First pass: identify active references and orphaned objects
    for (var i = 0; i < refArr.length; i++) {
        var rArr = refArr[i];
        var refName = rArr[0];
        var isOrphaned = rArr[5] === "ORPHANED";
        var isRemoved = rArr[5] === "REMOVED";
        var isAlias = rArr.length > 4 && rArr[4] && rArr[4] !== "ORPHANED" && rArr[4] !== "REMOVED";
        var objectId = rArr[6];  // Unique object ID
        
        if (isRemoved) {
            // This reference has been removed/replaced - skip it entirely
            console.log("Reference " + refName + " was removed (reassigned to new object)");
            continue;
        }
        
        if (isOrphaned) {
            // This object has no references anymore
            orphanedObjects.push(rArr);
            console.log("Object created by " + refName + " is now orphaned");
            continue;
        }
        
        if (isAlias) {
            // This is an alias (h2 = h1) - point to existing object
            var pointsTo = rArr[4];
            
            // Check if the pointsTo reference is still active
            var pointsToActive = false;
            for (var j = 0; j < refArr.length; j++) {
                if (refArr[j][0] === pointsTo && 
                    refArr[j][6] === objectId && 
                    refArr[j][5] !== "REMOVED" && 
                    refArr[j][5] !== "ORPHANED") {
                    pointsToActive = true;
                    break;
                }
            }
            
            // Use the object ID as key
            if (drawnObjects.has(objectId)) {
                drawnObjects.get(objectId).push(refName);
            } else {
                // Only include pointsTo if it's still active
                if (pointsToActive) {
                    drawnObjects.set(objectId, [pointsTo, refName]);
                } else {
                    drawnObjects.set(objectId, [refName]);
                }
            }
            console.log("Alias " + refName + " points to object " + objectId);
            
        } else {
            // This is a real object (new Human())
            // Use unique object ID as key
            if (!drawnObjects.has(objectId)) {
                drawnObjects.set(objectId, [refName]);
            } else {
                drawnObjects.get(objectId).push(refName);
            }
            console.log("Object " + objectId + " has reference: " + refName);
        }
    }
    
    // Clear canvas and redraw
    console.log("Drawing objects with their references:");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    x = 200;
    y = 100;
    
    var processedObjects = new Set();
    
    // Draw active objects (with references)
    for (var i = 0; i < refArr.length; i++) {
        var rArr = refArr[i];
        var isAlias = rArr.length > 4 && rArr[4] && rArr[4] !== "ORPHANED";
        var isOrphaned = rArr[5] === "ORPHANED";
        var objectId = rArr[6];  // Unique object ID
        
        if (!isAlias && !isOrphaned) {
            
            if (!processedObjects.has(objectId)) {
                processedObjects.add(objectId);
                
                var structure = [];
                var iVar = rArr[2];
                
                for (var j = 0; j < iVar.length; j++) {
                    ln = iVar[j][0] + " " + iVar[j][1];
                    if (iVar[j].length == 3) {
                        ln = ln + "=" + iVar[j][2] + ";";
                    } else {
                        ln = ln + ";";
                    }
                    structure.push(ln);
                }
                
                // Get all references to this object using unique ID
                var allReferences = drawnObjects.get(objectId) || [rArr[0]];
                console.log("Drawing object " + objectId + " with references:", allReferences);
                
                fillRectangle(structure, allReferences, false);
            }
        }
    }
    
    // Draw orphaned objects (no references)
    for (var o = 0; o < orphanedObjects.length; o++) {
        var orphan = orphanedObjects[o];
        var structure = [];
        var iVar = orphan[2];
        
        for (var j = 0; j < iVar.length; j++) {
            ln = iVar[j][0] + " " + iVar[j][1];
            if (iVar[j].length == 3) {
                ln = ln + "=" + iVar[j][2] + ";";
            } else {
                ln = ln + ";";
            }
            structure.push(ln);
        }
        
        console.log("Drawing orphaned object (created by " + orphan[0] + ")");
        fillRectangle(structure, ["(orphaned)"], true);
    }


}


function isClass(clsName) {
    return classArr.includes(clsName);
}

function clone(arr) {
    var clonedArr  =  [] ;
    for(var n = 0; n < arr.length ; n++){
        var nArr = arr[n];
        var aArr = [];
        for(var m = 0 ; m < nArr.length; m++){
            aArr.push(nArr[m]);
        }
        clonedArr.push(aArr);
    }
    console.log("array_clone");
    console.log(clonedArr);
    return clonedArr;
}

function getClassIndex(cls) {
    return classArr.indexOf(cls);
}


    $('.line-checkbox').on('click', function(){
       var lineNumber =  $(this).attr('value');
       var allChecks = document.getElementsByClassName('line-checkbox');
         for(var x = 0 ; x < allChecks.length ; x++){
            if(x  < parseInt(lineNumber)){
                allChecks[x].checked = true;
            }else{
                 allChecks[x].checked = false;
            }
         }
         showMemory();
    });
