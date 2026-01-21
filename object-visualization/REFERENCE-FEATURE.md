# 🎯 Reference Assignment Feature

## ✅ New Functionality Added

The Object Memory Visualizer now correctly handles **reference assignments** in Java!

---

## 📚 How It Works

### Before (Incorrect Behavior)
```java
Human h1 = new Human();
Human h2 = h1;  // ❌ Created a NEW object (wrong!)
```
**Result:** Two separate objects on canvas

### After (Correct Behavior)
```java
Human h1 = new Human();
Human h2 = h1;  // ✅ Points to SAME object (correct!)
```
**Result:** ONE object with TWO arrows pointing to it

---

## 🎨 Visual Representation

### Example Code:
```java
Human h1 = new Human();
h1.name = "John";
h1.age = 25;
Human h2 = h1;  // h2 points to same object as h1
h2.age = 30;    // This changes h1.age too!
```

### Canvas Output:
```
h1 ────┐
       │
h2 ────┤──→ [Object Box]
       │    │ String name = "John"
       └──→ │ int age = 30
            └─────────────────────
```

**Visual Indicators:**
- **Black arrow**: Original reference (h1)
- **Blue arrow**: Alias reference (h2)
- **Same box**: Both point to the same object

---

## 🔍 Technical Implementation

### 1. Detection Logic

```javascript
// Parse right side of assignment
var rightPartClean = rightPart.trim().replace(";", "").trim();

if (rightPartClean.startsWith("new ")) {
    // Case 1: New object creation
    // Human h1 = new Human();
    
} else {
    // Case 2: Reference assignment
    // Human h2 = h1;
    
    // Find existing object h1
    // Create alias that points to same object
}
```

### 2. Data Structure

**New Object:**
```javascript
ref = [
    "h1",                    // [0] Reference name
    "Human",                 // [1] Class name
    instanceVariables,       // [2] Instance vars (cloned)
    classVariables          // [3] Static vars (cloned)
]
```

**Alias Reference:**
```javascript
aliasRef = [
    "h2",                              // [0] Alias name
    "Human",                           // [1] Class name
    refArr[existingIndex][2],          // [2] SAME instance vars (NOT cloned!)
    refArr[existingIndex][3],          // [3] SAME static vars
    "h1"                               // [4] Points to this reference
]
```

### 3. Visualization

```javascript
// Draw object once
// Draw multiple arrows for all references
for (var r = 0; r < references.length; r++) {
    var refName = references[r];
    
    // First reference (black)
    if (r == 0) {
        ctx.fillStyle = "#000000";
    }
    // Additional references (blue)
    else {
        ctx.fillStyle = "#0052CC";
    }
    
    // Draw arrow with vertical offset
    // ...
}
```

---

## 💡 Supported Scenarios

### ✅ Scenario 1: Simple Reference
```java
Human h1 = new Human();
Human h2 = h1;
```
**Result:** h1 and h2 point to same object

### ✅ Scenario 2: Multiple References
```java
Human h1 = new Human();
Human h2 = h1;
Human h3 = h1;
Human h4 = h2;  // Points to h2, which points to h1
```
**Result:** h1, h2, h3, h4 all point to same object

### ✅ Scenario 3: Shared State
```java
Human h1 = new Human();
h1.name = "John";
Human h2 = h1;
h2.age = 25;    // Both h1 and h2 see age = 25
```
**Result:** ONE object with both properties set

### ✅ Scenario 4: Null Assignment
```java
Human h1 = null;  // No object created
```
**Result:** No object drawn

---

## 🎨 Visual Features

1. **Primary Reference (Black)**
   - First reference that created/points to object
   - Black arrow and label

2. **Alias References (Blue)**
   - Additional references to same object
   - Blue arrows and labels
   - Thicker lines (2px vs 1px)

3. **Vertical Stacking**
   - Multiple arrows stack vertically
   - Each offset by 35px
   - Easy to see all references

---

## 🔑 Key Benefits

✅ **Accurate Memory Model**: Shows true Java behavior  
✅ **Shared State**: Demonstrates why changes via h2 affect h1  
✅ **Visual Distinction**: Blue color for alias references  
✅ **Educational**: Helps understand Java references vs objects  

---

## 🧪 Test Cases

### Test 1: Basic Reference
```java
class Person { String name; }

Person p1 = new Person();
Person p2 = p1;
```
**Expected:** 1 object, 2 arrows (p1 black, p2 blue)

### Test 2: Reference Chain
```java
Person p1 = new Person();
Person p2 = p1;
Person p3 = p2;
```
**Expected:** 1 object, 3 arrows (p1 black, p2 & p3 blue)

### Test 3: Shared Modification
```java
Person p1 = new Person();
p1.name = "Alice";
Person p2 = p1;
p2.name = "Bob";
```
**Expected:** 1 object showing `name = "Bob"` (latest value)

---

## 🐛 Edge Cases Handled

1. ✅ **Null check**: `if (rightPart == "null")`
2. ✅ **New keyword check**: `if (rightPartClean.startsWith("new "))`
3. ✅ **Reference existence**: Validates reference exists before aliasing
4. ✅ **Semicolon removal**: Cleans right side properly
5. ✅ **Whitespace handling**: Trims properly

---

## 📊 Algorithm Summary

```
For each line:
  If line has "=":
    Parse left and right sides
    
    If right side has "new":
      → Create NEW object
      → Clone variables
      → Add to refArr
      
    Else if right side is existing reference:
      → Create ALIAS
      → Use SAME variables (no clone!)
      → Add pointer marker
      
  Draw objects:
    For each unique object:
      → Draw box once
      → Draw ALL arrows pointing to it
      → Color aliases blue
```

---

## 🎓 Educational Value

This enhancement teaches students:
1. **References vs Objects**: References are not objects
2. **Shallow Copy**: Multiple references to same object
3. **Shared State**: Changes via any reference affect all
4. **Memory Efficiency**: Java reuses objects

Perfect for teaching Java memory management! 🚀

