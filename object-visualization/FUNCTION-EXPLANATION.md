# loadObjects() Function Explanation

## 🎯 Purpose
Parses Java code line-by-line and creates visual memory representation of objects on the canvas.

## 📋 Function Flow

### Step 1: Initialize Arrays
```javascript
var refArr = [];      // Stores all object references
var refName = [];     // Stores reference names
```

### Step 2: Get Code and Split into Lines
```javascript
var clsTxt = document.getElementById('codearea').value;
var lines1 = clsTxt.split("\n");
```

### Step 3: Process Each Line (if checkbox checked)
```javascript
for (var x = 0; x < lines1.length; x++) {
    if(document.getElementById('check'+(x+1)).checked == false){
        continue;  // Skip unchecked lines
    }
    var line = lines1[x].trim();
    ...
}
```

---

## 🔍 Two Types of Assignments Detected

### Type 1: Object Creation (NEW OBJECT)
**Pattern:** `ClassName refName = new ClassName();`

**Example:**
```java
Human h1 = new Human();
```

**Processing:**
1. Split by "=" → leftPart: `Human h1`, rightPart: `new Human()`
2. Split leftPart by space → `["Human", "h1"]`
3. lside.length == 2 (means object creation)
4. Create reference array:
   ```javascript
   ref = [
       "h1",                         // [0] Reference name
       "Human",                      // [1] Class name
       clone(instanceVariables),     // [2] Instance variables
       clone(classVariables)         // [3] Static variables
   ]
   ```
5. Add to `refArr`

**Special Case:** If `rightPart == "null"`, doesn't create object (just reference to null)

---

### Type 2: Property Assignment (UPDATE PROPERTY)
**Pattern:** `objRef.propertyName = value;`

**Example:**
```java
h1.name = "John";
```

**Processing:**
1. Split by "=" → leftPart: `h1.name`, rightPart: `"John"`
2. Split leftPart by space → `["h1.name"]`
3. lside.length == 1 (means property assignment)
4. Split by "." → `["h1", "name"]`
5. Extract:
   - refVariable: `"h1"`
   - variName: `"name"`
   - variValue: `"John"`

6. Find the object in `refArr`:
   ```javascript
   for (var k = 0; k < refArr.length; k++) {
       if (refArr[k][0] == refVariable) {  // Found "h1"
           iArr = refArr[k][2];  // Get instance variables
           // Update the variable
           for (var k1 = 0; k1 < iArr.length; k1++) {
               if (iArr[k1][1] == variName) {  // Found "name"
                   if (iArr[k1].length > 2) {
                       iArr[k1][2] = variValue;  // Update value
                   } else {
                       iArr[k1].push(variValue);  // Add value
                   }
               }
           }
       }
   }
   ```

7. Also checks if it's a **static variable**:
   ```javascript
   for (var k2 = 0; k2 < classVariables.length; k2++) {
       if (classVariables[k2][1] == variName) {
           // Update static variable value
       }
   }
   ```

---

## 🎨 Visualization Step

After processing all lines, draw the objects:

```javascript
for (var i = 0; i < refArr.length; i++) {
    var structure = [];
    rArr = refArr[i];
    iVar = rArr[2];  // Get instance variables
    
    // Build structure array
    for (var j = 0; j < iVar.length; j++) {
        ln = iVar[j][0] + " " + iVar[j][1];  // "String name"
        if (iVar[j].length == 3) {
            ln = ln + "=" + iVar[j][2] + ";";  // "String name=John;"
        } else {
            ln = ln + ";";  // "String name;"
        }
        structure.push(ln);
    }
    
    fillRectangle(structure, rArr[0]);  // Draw on canvas
}
```

---

## 📊 Data Structures

### refArr Structure
```javascript
refArr = [
    [
        "h1",                    // [0] Reference name
        "Human",                 // [1] Class name
        [                        // [2] Instance variables
            ["String", "name", "John"],
            ["int", "age", "25"]
        ],
        [                        // [3] Static variables (if any)
            ["static", "String", "country", "USA"]
        ]
    ],
    // ... more objects
]
```

### Instance Variables Array
```javascript
instanceVariables = [
    ["String", "name"],          // No value yet
    ["int", "age", "25"]         // Has value
]
```

### Class Variables Array
```javascript
classVariables = [
    ["static", "String", "species", "Human"]
]
```

---

## 💡 Example Walkthrough

**Class Definition:**
```java
class Human {
    String name;
    int age;
    static String species = "Homo Sapiens";
}
```

**Code to Execute:**
```java
Human h1 = new Human();
h1.name = "John";
h1.age = 25;
Human h2 = new Human();
h2.name = "Jane";
```

**Processing:**

1. **Line 1:** `Human h1 = new Human();`
   - Creates object: `["h1", "Human", [["String","name"], ["int","age"]], [["static","String","species","Homo Sapiens"]]]`
   - Added to refArr

2. **Line 2:** `h1.name = "John";`
   - Finds h1 in refArr
   - Updates: `["String", "name"]` → `["String", "name", "John"]`

3. **Line 3:** `h1.age = 25;`
   - Finds h1 in refArr
   - Updates: `["int", "age"]` → `["int", "age", "25"]`

4. **Line 4:** `Human h2 = new Human();`
   - Creates new object: `["h2", "Human", [["String","name"], ["int","age"]], ...]`

5. **Line 5:** `h2.name = "Jane";`
   - Finds h2 in refArr
   - Updates: `["String", "name"]` → `["String", "name", "Jane"]`

**Final refArr:**
```javascript
[
    ["h1", "Human", [["String","name","John"], ["int","age","25"]], [...]],
    ["h2", "Human", [["String","name","Jane"], ["int","age"]], [...]]
]
```

---

## 🔑 Key Features

1. **Line-by-Line Execution**: Only processes checked lines
2. **Object Tracking**: Maintains all created objects in refArr
3. **Property Updates**: Can modify object properties after creation
4. **Static Variables**: Handles both instance and static variables
5. **Null Handling**: Supports `Object obj = null;`
6. **Deep Cloning**: Uses `clone()` to avoid reference issues

---

## 🐛 Important Points

- **Checkbox Control**: Line only executes if checkbox is checked
- **Sequential Processing**: Lines process in order (important for assignments)
- **Deep Copy**: Uses `clone()` to create independent copies of variable arrays
- **Canvas Drawing**: Calls `fillRectangle()` to visualize each object

---

## 🎯 Summary

The `loadObjects()` function:
1. ✅ Parses Java code from textarea
2. ✅ Identifies object creation vs property assignment
3. ✅ Tracks all objects with their variables
4. ✅ Updates values when properties are assigned
5. ✅ Visualizes final state on canvas

It's essentially a **mini Java interpreter** for object memory visualization! 🚀

