<?php
session_start();
$basedir = "../../";
include_once $basedir.'php/session_management.php';

login_required();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Java Object Memory Visualizer | Interactive Java Memory Management Tool | TechElliptica</title>
    <meta name="title" content="Java Object Memory Visualizer | Interactive Java Memory Management Tool | TechElliptica">
    <meta name="description" content="Visualize Java object memory allocation in real-time. Interactive tool to understand heap memory, stack, object references, and garbage collection. Perfect for Java developers and students learning memory management.">
    <meta name="keywords" content="Java memory visualizer, Java heap memory, Java object visualization, Java memory management, Java stack and heap, Java garbage collection, Java memory allocation, Java reference visualization, Java learning tool, Java memory tutorial, object memory diagram, Java heap visualization, JVM memory, Java programming tool, interactive Java memory, TechElliptica Java tools">
    <meta name="author" content="Vaibhav Singh, TechElliptica">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://techelliptica.com/apps/object-visualization/object-visualizer.php">
    <meta property="og:title" content="Java Object Memory Visualizer | Interactive Learning Tool">
    <meta property="og:description" content="Visualize Java object memory allocation in real-time. Understand heap memory, stack, object references, and garbage collection with this interactive tool.">
    <meta property="og:image" content="https://techelliptica.com/images/teche-app/java-memory-visualizer.png">
    <meta property="og:site_name" content="TechElliptica">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://techelliptica.com/apps/object-visualization/object-visualizer.php">
    <meta name="twitter:title" content="Java Object Memory Visualizer | Interactive Learning Tool">
    <meta name="twitter:description" content="Visualize Java object memory allocation in real-time. Perfect for learning Java memory management, heap, stack, and garbage collection.">
    <meta name="twitter:image" content="https://techelliptica.com/images/teche-app/java-memory-visualizer.png">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://techelliptica.com/apps/object-visualization/object-visualizer.php">
    
    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="#0052CC">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Java Memory Visualizer">
    
    <!-- Structured Data / Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "Java Object Memory Visualizer",
        "applicationCategory": "DeveloperApplication",
        "applicationSubCategory": "Educational Tool",
        "operatingSystem": "Web Browser",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "creator": {
            "@type": "Person",
            "name": "Vaibhav Singh"
        },
        "provider": {
            "@type": "Organization",
            "name": "TechElliptica",
            "url": "https://techelliptica.com"
        },
        "description": "Interactive Java Object Memory Visualizer helps developers and students understand Java memory management, heap memory, stack, object references, and garbage collection through real-time visualization.",
        "featureList": [
            "Real-time memory visualization",
            "Object reference tracking",
            "Heap and stack visualization",
            "Interactive code execution",
            "Step-by-step memory allocation",
            "Garbage collection simulation"
        ],
        "keywords": "Java, memory management, heap, stack, visualization, object references, garbage collection, learning tool"
    }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            background: #F4F5F7;
            color: #172B4D;
            line-height: 1.4;
        }
        
        /* JIRA-style Header */
        .jira-header {
            background: #0052CC;
            color: white;
            padding: 12px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .jira-header h1 {
            font-size: 20px;
            font-weight: 500;
            letter-spacing: -0.01em;
        }
        
        .jira-breadcrumb {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* Main Container */
        .jira-container {
            max-width: 1600px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .jira-layout {
            display: flex;
            gap: 20px;
        }
        
        /* Left Panel */
        .jira-panel {
            background: white;
            border-radius: 3px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
            padding: 20px;
            flex: 1;
        }
        
        .jira-panel-header {
            font-size: 14px;
            font-weight: 600;
            color: #172B4D;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 2px solid #DFE1E6;
        }
        
        /* Form Groups */
        .jira-form-group {
            margin-bottom: 20px;
        }
        
        .jira-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #6B778C;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .jira-textarea {
            width: 100%;
            padding: 8px 12px;
            font-size: 18px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            border: 2px solid #DFE1E6;
            border-radius: 3px;
            transition: border-color 0.2s;
            background: #FAFBFC;
            color: #172B4D;
            resize: vertical;
        }
        
        .jira-textarea:hover {
            border-color: #B3BAC5;
        }
        
        .jira-textarea:focus {
            outline: none;
            border-color: #0052CC;
            background: white;
        }
        
        /* Code Block */
        .jira-code-block {
            background: #F4F5F7;
            border: 1px solid #DFE1E6;
            border-radius: 3px;
            padding: 12px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 18px;
        }
        
        .code-keyword {
            color: #0747A6;
            font-weight: 600;
        }
        
        .code-class {
            color: #BF2600;
            font-weight: 600;
        }
        
        /* Checkbox Grid */
        .jira-checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 8px;
            padding: 12px;
            background: #F4F5F7;
            border: 1px solid #DFE1E6;
            border-radius: 3px;
            margin-bottom: 15px;
        }
        
        .jira-checkbox-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .jira-checkbox-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #0052CC;
        }
        
        .jira-checkbox-item label {
            font-size: 12px;
            color: #42526E;
            cursor: pointer;
            user-select: none;
        }
        
        /* Buttons */
        .jira-button-group {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }
        
        .jira-button {
            padding: 8px 12px;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .jira-button-primary {
            background: #0052CC;
            color: white;
        }
        
        .jira-button-primary:hover {
            background: #0747A6;
        }
        
        .jira-button-secondary {
            background: white;
            color: #42526E;
            border: 2px solid #DFE1E6;
        }
        
        .jira-button-secondary:hover {
            background: #F4F5F7;
        }
        
        /* Canvas Panel */
        .jira-canvas-panel {
            background: white;
            border-radius: 3px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
            padding: 20px;
            flex: 1;
        }
        
        .jira-canvas-container {
            border: 1px solid #DFE1E6;
            border-radius: 3px;
            padding: 16px;
            background: #FAFBFC;
            overflow: auto;
        }
        
        #myCanvas {
            display: block;
            border: 1px dashed #C1C7D0;
            background: white;
        }
        
        /* Utility */
        .hidden {
            display: none;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .jira-layout {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<!-- JIRA-style Header -->
<div class="jira-header">
    <div style="flex: 1;">
        <h1>Java Object Memory Visualizer</h1>
        <span class="jira-breadcrumb">/ Java / Memory Visualization / Interactive Learning Tool</span>
    </div>
    <div style="text-align: right; font-size: 12px; opacity: 0.9;">
        <div>Powered by <strong>TechElliptica</strong></div>
        <div style="font-size: 10px; margin-top: 3px;">All Rights Reserved © TechElliptica</div>
        <div style="margin-top: 5px;">
            <a href="../terms-and-conditions.php" target="_blank" style="color: white; text-decoration: underline; font-size: 11px;">Terms & Conditions</a>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="jira-container">
    <div class="jira-layout">
        <!-- Left Panel: Code Input -->
        <div class="jira-panel">
            <div class="jira-panel-content" style="display:flex;justify-content:space-between;align-items:center;">
            <div class="jira-panel-header">Code Editor</div>
            <div><button class="jira-button jira-button-primary" onclick="showMemory();">
                <span>▶</span>
                <span>Visualize Memory</span>
            </button></div>
            </div>
            <!-- Class Definition -->
            <div class="jira-form-group">
                <label class="jira-label">Class Definition</label>
                <textarea class="jira-textarea" style="height:200px;" id="classarea">class Human{
String name;
int age;
}</textarea>
            </div>

            <!-- Code Template Display -->
            <div class="jira-code-block">
                <div style="line-height:24px;">
                    <span class="code-keyword">class</span> 
                    <span class="code-class">TechEllipticaSnippet</span> {
                </div>
                <div style="line-height:24px; padding-left: 20px;">
                    <span class="code-keyword">public static void</span> main(String[] args) {
                </div>
            </div>

            <!-- Line Selection -->
            <div class="jira-form-group" style="display:none;">
                <label class="jira-label">Line-by-Line Execution</label>
                <div class="jira-checkbox-grid" id="lines-block">
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check1" class="line-checkbox" name="lines" value="1"/>
                        <label for="check1">Line 1</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check2" class="line-checkbox" name="lines" value="2"/>
                        <label for="check2">Line 2</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check3" class="line-checkbox" name="lines" value="3"/>
                        <label for="check3">Line 3</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check4" class="line-checkbox" name="lines" value="4"/>
                        <label for="check4">Line 4</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check5" class="line-checkbox" name="lines" value="5"/>
                        <label for="check5">Line 5</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check6" class="line-checkbox" name="lines" value="6"/>
                        <label for="check6">Line 6</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check7" class="line-checkbox" name="lines" value="7"/>
                        <label for="check7">Line 7</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check8" class="line-checkbox" name="lines" value="8"/>
                        <label for="check8">Line 8</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check9" class="line-checkbox" name="lines" value="9"/>
                        <label for="check9">Line 9</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check10" class="line-checkbox" name="lines" value="10"/>
                        <label for="check10">Line 10</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check11" class="line-checkbox" name="lines" value="11"/>
                        <label for="check11">Line 11</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check12" class="line-checkbox" name="lines" value="12"/>
                        <label for="check12">Line 12</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check13" class="line-checkbox" name="lines" value="13"/>
                        <label for="check13">Line 13</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check14" class="line-checkbox" name="lines" value="14"/>
                        <label for="check14">Line 14</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check15" class="line-checkbox" name="lines" value="15"/>
                        <label for="check15">Line 15</label>
                    </div>
                    <div class="jira-checkbox-item">
                        <input checked type="checkbox" id="check16" class="line-checkbox" name="lines" value="16"/>
                        <label for="check16">Line 16</label>
                    </div>
                </div>
            </div>

            <!-- Code Input -->
            <div class="jira-form-group">
                <textarea class="jira-textarea" style="height:400px;" id="codearea"></textarea>
            </div>

            <!-- Closing Braces -->
            <div class="jira-code-block">
                <div style="line-height:24px; padding-left: 20px;">}</div>
                <div style="line-height:24px;">}</div>
            </div>

            <!-- Action Buttons -->
            <div class="jira-button-group">
                <button class="jira-button jira-button-primary" onclick="showMemory();">
                    <span>▶</span>
                    <span>Visualize Memory</span>
                </button>
            </div>
        </div>

        <!-- Right Panel: Canvas -->
        <div class="jira-canvas-panel">
            <div class="jira-panel-header">Memory Representation</div>
            <div class="jira-canvas-container">
                <canvas id="myCanvas" width="800" height="1000"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="main-min.js"></script>
</body>
</html>