// Shared utilities for all data structure visualizers

class BaseVisualizer {
    constructor(app) {
        this.app = app;
        this.data = [];
        this.steps = [];
        this.currentStepIndex = 0;
    }

    getOperations() {
        return [
            { name: 'add', label: 'Add/Insert', type: 'primary' },
            { name: 'remove', label: 'Remove/Delete', type: 'danger' },
            { name: 'search', label: 'Search/Contains', type: 'success' },
            { name: 'clear', label: 'Clear', type: 'secondary' }
        ];
    }

    getExamples() {
        return [
            { label: 'Example 1', data: [1, 2, 3, 4, 5] },
            { label: 'Example 2', data: [10, 20, 30] }
        ];
    }

    executeOperation(op, values, key) {
        // Override in subclasses
    }

    render() {
        // Override in subclasses
    }

    getState() {
        return {
            type: this.constructor.name,
            data: this.data,
            timestamp: new Date().toISOString()
        };
    }

    stepForward() {
        if (this.currentStepIndex < this.steps.length - 1) {
            this.currentStepIndex++;
            this.render();
        }
    }

    stepBack() {
        if (this.currentStepIndex > 0) {
            this.currentStepIndex--;
            this.render();
        }
    }

    reset() {
        this.data = [];
        this.steps = [];
        this.currentStepIndex = 0;
        this.render();
    }

    renderComplexity(complexities) {
        return `
            <div class="complexity-panel">
                <h4>Time Complexity</h4>
                ${complexities.map(c => `
                    <div class="complexity-item">
                        <span>${c.operation}:</span>
                        <span>${c.complexity}</span>
                    </div>
                `).join('')}
            </div>
        `;
    }

    renderCodeSnippet(language, code) {
        return `
            <div class="code-snippet">
                <h4>${language} Implementation</h4>
                <pre>${code}</pre>
            </div>
        `;
    }

    renderMemoryView(info) {
        return `
            <div class="memory-view">
                <h4>Memory Layout</h4>
                ${info.map(i => `<p>${i}</p>`).join('')}
            </div>
        `;
    }
}

// Theme management
function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-theme', savedTheme);
    updateThemeButton();
}

function toggleTheme() {
    const currentTheme = document.body.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeButton();
}

function updateThemeButton() {
    const btn = document.querySelector('.theme-toggle');
    if (btn) {
        btn.textContent = document.body.getAttribute('data-theme') === 'dark' 
            ? '☀️ Light Mode' 
            : '🌙 Dark Mode';
    }
}

// Export utilities
function exportJSON(data, filename) {
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename || 'data-structure-state.json';
    a.click();
    URL.revokeObjectURL(url);
}

// Hash function for hash tables
function hashString(str, capacity) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        const char = str.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return Math.abs(hash) % capacity;
}

function hashNumber(num, capacity) {
    return Math.abs(num) % capacity;
}

// Parse input values
function parseInput(input, dataType) {
    if (!input.trim()) return [];
    
    const separators = /[,\s\n]+/;
    return input.split(separators)
        .map(v => v.trim())
        .filter(v => v)
        .map(v => {
            if (dataType === 'number') {
                const num = Number(v);
                return isNaN(num) ? v : num;
            }
            return v;
        });
}

// Tree node class for BST/AVL
class TreeNode {
    constructor(value) {
        this.value = value;
        this.left = null;
        this.right = null;
        this.parent = null;
        this.height = 1;
        this.balance = 0;
    }
}

// Initialize theme on load
if (typeof window !== 'undefined') {
    window.addEventListener('DOMContentLoaded', initTheme);
}

