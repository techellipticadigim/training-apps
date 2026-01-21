# 🔄 Reference Reassignment Feature

## ✅ New Functionality: Handle Reference Reassignment

The visualizer now correctly handles when a reference is **reassigned** to point to a different object!

---

## 🎯 Your Scenario

### Code Example:
```java
Human h1 = new Human();
Human h4 = new Human();
h4 = h1;
```

### What Happens:

**Line 1:** `Human h1 = new Human();`
- ✅ Creates Object A
- ✅ h1 points to Object A

**Line 2:** `Human h4 = new Human();`
- ✅ Creates Object B
- ✅ h4 points to Object B

**Line 3:** `h4 = h1;`
- ✅ h4 **stops** pointing to Object B
- ✅ h4 **now** points to Object A (same as h1)
- ❌ Object B becomes **orphaned** (no references)

---

## 🎨 Visual Representation

### Before Reassignment (after line 2):
```
h1 ──→ [Object A]
       │ String name;
       │ int age;
       └──────────

h4 ──→ [Object B]
       │ String name;
       │ int age;
       └──────────
```

### After Reassignment (after line 3):
```
h1 (black) ──┐
             ├──→ [Object A]
h4 (blue)  ──┘    │ String name;
                  │ int age;
                  └──────────

     (no references) [Object B] ← Orphaned (gray, dashed)
                     │ String name;
                     │ int age;
                     └──────────
```

---

## 🔍 How It Works

### 1. Detection
```javascript
if (lside.length == 1) {
    if (lside[0].includes(".")) {
        // Property assignment: h1.name = "John"
    } else {
        // Reference reassignment: h4 = h1
        // This is the NEW case!
    }
}
```

### 2. Processing Steps

**Step A: Mark Old Object as Orphaned**
```javascript
for (var k = 0; k < refArr.length; k++) {
    if (refArr[k][0] == "h4") {
        refArr[k][5] = "ORPHANED";  // Mark Object B as orphaned
        break;
    }
}
```

**Step B: Create New Alias**
```javascript
// Find h1's object
// Create h4 as alias pointing to h1's object
aliasRef = [
    "h4",              // Reference name
    "Human",           // Class name
    h1.instanceVars,   // SAME object as h1
    h1.staticVars,     // SAME statics
    "h1"               // Points to h1
];
```

**Step C: Visualize**
- Draw h1's object with TWO arrows (h1 and h4)
- Draw orphaned Object B in gray with dashed border
- Label it "(no references)"

---

## 💡 More Complex Examples

### Example 1: Chain Reassignment
```java
Human h1 = new Human();
Human h2 = new Human();
Human h3 = new Human();
h2 = h1;
h3 = h1;
```

**Result:**
- ✅ h1, h2, h3 all point to Object A
- ❌ Object B (orphaned)
- ❌ Object C (orphaned)

### Example 2: Swap References
```java
Human h1 = new Human();
Human h2 = new Human();
h1.name = "Alice";
h2.name = "Bob";
Human temp = h1;
h1 = h2;
h2 = temp;
```

**Result:**
- h1 now points to object with name="Bob"
- h2 now points to object with name="Alice"
- temp points to object with name="Alice" (same as h2)

### Example 3: Your Exact Scenario
```java
Human h1 = new Human();
h1.name = "John";
Human h4 = new Human();
h4.name = "Mike";
h4 = h1;
```

**Memory State:**
```
h1 (black) ──┐
             ├──→ [Object A]
h4 (blue)  ──┘    │ String name="John";
                  │ int age;
                  └──────────

     (no references) [Object B] ← Will be garbage collected
                     │ String name="Mike";
                     │ int age;
                     └──────────
```

---

## 🎨 Visual Indicators

### Active Objects (with references):
- ✅ **Solid black border**
- ✅ **Black text**
- ✅ **Black arrow** for primary reference
- ✅ **Blue arrows** for alias references
- ✅ **Multiple arrows** if multiple references

### Orphaned Objects (no references):
- ⚠️ **Dashed gray border**
- ⚠️ **Gray text**
- ⚠️ **Label: "(no references)"**
- ⚠️ **No arrows pointing to it**

---

## 🔑 Key Concepts Demonstrated

### 1. **Reference vs Object**
- References are variables
- Objects are memory blocks
- Multiple references can point to same object

### 2. **Reassignment**
- `h4 = h1` changes where h4 points
- Original object becomes orphaned
- In real Java: Garbage collected

### 3. **Shared State**
- h1 and h4 share the same object
- Changes via h4 affect h1
- They're different names for the same thing

### 4. **Memory Management**
- Orphaned objects are eligible for garbage collection
- Shown in gray with dashed lines
- No references = will be cleaned up

---

## 🧪 Test Cases

### Test 1: Simple Reassignment
```java
Human h1 = new Human();
Human h2 = new Human();
h2 = h1;
```
**Expected:**
- 1 active object (h1 and h2 point to it)
- 1 orphaned object (gray, dashed)

### Test 2: Multiple Reassignments
```java
Human h1 = new Human();
Human h2 = new Human();
Human h3 = new Human();
h2 = h1;
h3 = h1;
```
**Expected:**
- 1 active object (h1, h2, h3 point to it)
- 2 orphaned objects (gray, dashed)

### Test 3: Property Before Reassignment
```java
Human h1 = new Human();
h1.name = "Alice";
Human h4 = new Human();
h4.name = "Bob";
h4 = h1;
h4.age = 25;
```
**Expected:**
- Active object shows: name="Alice", age=25 (both h1 and h4)
- Orphaned object shows: name="Bob" (no age)

---

## 📊 Implementation Details

### Reference Array Structure:

**Normal Object:**
```javascript
[
    "h1",              // [0] Reference name
    "Human",           // [1] Class type
    instanceVars,      // [2] Instance variables
    staticVars,        // [3] Static variables
    undefined,         // [4] Not an alias
    undefined          // [5] Not orphaned
]
```

**Alias Reference:**
```javascript
[
    "h4",              // [0] Alias name
    "Human",           // [1] Class type
    h1.instanceVars,   // [2] SAME as h1 (shared!)
    h1.staticVars,     // [3] SAME as h1
    "h1",              // [4] Points to h1
    undefined          // [5] Not orphaned
]
```

**Orphaned Object:**
```javascript
[
    "h4",              // [0] Original reference
    "Human",           // [1] Class type
    instanceVars,      // [2] Its own variables
    staticVars,        // [3] Its own statics
    undefined,         // [4] Not an alias
    "ORPHANED"         // [5] Marked as orphaned!
]
```

---

## 🚀 Benefits

✅ **Real Java Behavior**: Accurately simulates reference reassignment  
✅ **Garbage Collection Visualization**: Shows orphaned objects  
✅ **Educational**: Teaches memory management concepts  
✅ **Visual Clarity**: Gray/dashed = orphaned, Blue = alias  
✅ **Complete Tracking**: Handles all assignment scenarios  

---

## 🎓 Educational Value

This teaches students:
1. **References are Pointers**: They can be reassigned
2. **Object Lifecycle**: Creation → Active → Orphaned → GC
3. **Memory Leaks**: What happens when objects lose references
4. **Garbage Collection**: Why Java needs it
5. **Shared Objects**: Multiple refs to same memory

Perfect for Java memory management education! 🎯

