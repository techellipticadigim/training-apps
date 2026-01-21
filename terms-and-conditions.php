<?php 

$basedir = "../";

if(!isset($_SESSION)) 
{
	session_start();
}
include_once $basedir.'php/session_management.php';
include $basedir.'php/fileutils.php';
include_once $basedir.'php/dbglobal.php';
include_once $basedir.'php/dbcreds.php';
include_once $basedir.'php/components.php';

$topicValue = "Terms and Conditions"
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Terms and Conditions - TechElliptica Apps</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Terms and Conditions for TechElliptica Applications and Tools. Read our intellectual property rights, usage guidelines, and legal information.">
<meta name="keywords" content="terms and conditions, terms of service, legal, intellectual property, TechElliptica, usage policy">
<meta name="author" content="Tech Elliptica">

<?php include $basedir.'parts/quilljs-top.php';?>
<?php include $basedir.'parts/ico.php';?>
<?php include $basedir.'parts/css.php';?>
<?php include $basedir.'parts/page-responsive-head.php';?>
<?php include $basedir.'parts/quilljs-bottom.php';?>

<style>
    .terms-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 20px;
    }
    
    .content-card {
        background: white;
        border-radius: 3px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08);
        padding: 40px;
    }
    
    .last-updated {
        background: #FFF3CD;
        border: 1px solid #FFC107;
        padding: 12px 20px;
        border-radius: 3px;
        margin-bottom: 30px;
        font-size: 13px;
        color: #856404;
        font-weight: 600;
    }
    
    .content-card h2 {
        color: #172B4D;
        font-size: 24px;
        margin: 30px 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #DFE1E6;
    }
    
    .content-card h2:first-of-type {
        margin-top: 0;
    }
    
    .content-card h3 {
        color: #42526E;
        font-size: 18px;
        margin: 20px 0 10px 0;
    }
    
    .content-card p {
        margin-bottom: 15px;
        color: #42526E;
        line-height: 1.6;
    }
    
    .content-card ul, 
    .content-card ol {
        margin: 15px 0 15px 30px;
        color: #42526E;
    }
    
    .content-card li {
        margin-bottom: 10px;
    }
    
    .important-box {
        background: #FFEBE6;
        border-left: 4px solid #BF2600;
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 3px;
    }
    
    .important-box strong {
        color: #BF2600;
    }
    
    .info-box {
        background: #DEEBFF;
        border-left: 4px solid #0052CC;
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 3px;
    }
    
    .company-name {
        font-weight: 700;
        color: #0052CC;
    }
    
    .info-box a {
        color: #0052CC;
        font-weight: 600;
        text-decoration: none;
    }
    
    .info-box a:hover {
        text-decoration: underline;
    }
</style>

</head>

<body style="background:white;">
	<div id="main"><?php include $basedir.'parts/topheader.php';?>
		<div class="top2_wrapper">
			<div class="bg1"><img src="<?php echo $basedir ?>/images/bg1.jpg" alt="" class="img"></div>
			<div class="top2_inner">
				<?php include $basedir.'parts/menubar.php';?>
				<div class="divider"></div>
				</div>	
		</div>

		<div id="form-container" class="container">
		<div class="row" style="margin-top:50px;">
            <div class="span12" style="font-size:18px;">
                <nav aria-label="Breadcrumb">
                    <ol style="list-style: none; padding: 0; margin: 20px 0; font-size: 14px;">
                        <li style="display: inline;"><a href="<?php echo getHost() ?>" style="color: #2a1379; text-decoration: none;">TechElliptica</a></li>
                        <li style="display: inline; margin: 0 10px; color: #666;">›</li>
                        <li style="display: inline;"><a href="<?php echo getHost() ?>/apps/all.php" style="color: #2a1379; text-decoration: none;">Apps</a></li>
                        <li style="display: inline; margin: 0 10px; color: #666;">›</li>
                        <li style="display: inline;">Terms and Conditions</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
			<div class="span12">
                <h2>Terms and Conditions</h2>
			</div>
		</div>
		
        <div class="terms-container">
            <div class="content-card">
                <div class="last-updated">
                    📅 Last Updated: October 25, 2025
                </div>
                
                <h2>1. Acceptance of Terms</h2>
                <p>
                    By accessing or using any application, tool, or service (collectively "Apps") developed, hosted, 
                    or provided by <span class="company-name">TechElliptica</span>, you agree to be bound by these 
                    Terms and Conditions. If you do not agree to these terms, you must not access or use our Apps.
                </p>
                
                <h2>2. Intellectual Property Rights</h2>
                
                <div class="important-box">
                    <strong>⚠️ IMPORTANT:</strong> All applications, tools, software, code, documentation, and 
                    related materials belonging to TechElliptica are the exclusive property of 
                    <span class="company-name">TechElliptica</span>.
                </div>
                
                <p>
                    This includes but is not limited to:
                </p>
                <ul>
                    <li><strong>Source Code:</strong> All programming code, scripts, and algorithms</li>
                    <li><strong>User Interface:</strong> Design, layout, graphics, and visual elements</li>
                    <li><strong>Documentation:</strong> Guides, tutorials, and help materials</li>
                    <li><strong>Databases:</strong> Data structures, schemas, and content</li>
                    <li><strong>Logos and Trademarks:</strong> TechElliptica name, logo, and branding</li>
                    <li><strong>Educational Content:</strong> Courses, tutorials, and learning materials</li>
                </ul>
                
                <h2>3. Prohibited Activities</h2>
                
                <div class="important-box">
                    <strong>⚖️ LEGAL NOTICE:</strong> The following activities are strictly prohibited and 
                    may result in legal action:
                </div>
                
                <h3>3.1 Copying and Cloning</h3>
                <p>You are expressly prohibited from:</p>
                <ul>
                    <li>Copying, duplicating, or replicating any TechElliptica application or tool</li>
                    <li>Creating derivative works based on our Apps without written permission</li>
                    <li>Reverse engineering, decompiling, or disassembling our software</li>
                    <li>Extracting source code or attempting to derive the underlying algorithms</li>
                    <li>Cloning the application structure, design, or functionality</li>
                </ul>
                
                <h3>3.2 Unauthorized Distribution</h3>
                <p>You may not:</p>
                <ul>
                    <li>Redistribute, resell, or sublicense any TechElliptica App</li>
                    <li>Host our Apps on third-party servers without authorization</li>
                    <li>Share access credentials with unauthorized users</li>
                    <li>Create mirrors or copies of our applications</li>
                </ul>
                
                <h3>3.3 Modification and Adaptation</h3>
                <p>Unauthorized modification is prohibited:</p>
                <ul>
                    <li>Modifying the application code without permission</li>
                    <li>Removing or altering copyright notices, branding, or attributions</li>
                    <li>Creating modified versions for public or commercial use</li>
                    <li>Integrating our Apps into third-party applications without consent</li>
                </ul>
                
                <h2>4. Legal Obligations and Consequences</h2>
                
                <div class="important-box">
                    <strong>⚖️ LEGAL ACTION:</strong> In case of unauthorized copying, cloning, or distribution 
                    of any TechElliptica application, the violator will face:
                </div>
                
                <ol>
                    <li><strong>Immediate Legal Action:</strong> TechElliptica reserves the right to pursue legal 
                        remedies including civil lawsuits and criminal prosecution where applicable.</li>
                    
                    <li><strong>Financial Damages:</strong> Violators may be liable for:
                        <ul>
                            <li>Actual damages suffered by TechElliptica</li>
                            <li>Statutory damages as permitted by law</li>
                            <li>Legal fees and costs of enforcement</li>
                            <li>Lost profits and business opportunities</li>
                        </ul>
                    </li>
                    
                    <li><strong>Injunctive Relief:</strong> TechElliptica may seek court orders to:
                        <ul>
                            <li>Immediately cease all unauthorized use</li>
                            <li>Remove all copies and derivative works</li>
                            <li>Prevent future violations</li>
                        </ul>
                    </li>
                    
                    <li><strong>Criminal Penalties:</strong> Copyright infringement may result in criminal prosecution 
                        under applicable laws, including potential imprisonment and fines.</li>
                </ol>
                
                <h2>5. Ownership and Copyright</h2>
                
                <div class="info-box">
                    <strong>© Copyright Notice:</strong> All TechElliptica applications, tools, and content are 
                    protected by copyright laws and international treaties. Copyright © 2025 TechElliptica. 
                    All rights reserved worldwide.
                </div>
                
                <p>
                    TechElliptica retains all rights, title, and interest in and to the Apps, including all 
                    intellectual property rights. No ownership rights are transferred to users through access 
                    or use of the Apps.
                </p>
                
                <h2>6. Permitted Use</h2>
                
                <p>Subject to these Terms, TechElliptica grants you a limited, non-exclusive, non-transferable, 
                revocable license to:</p>
                <ul>
                    <li>Access and use the Apps for personal or educational purposes</li>
                    <li>Use the Apps as intended for learning and development</li>
                    <li>Create content using the Apps for your own use</li>
                </ul>
                
                <p><strong>This license does NOT include the right to:</strong></p>
                <ul>
                    <li>Copy, clone, or reproduce the application code or structure</li>
                    <li>Sell, lease, or commercially exploit the Apps</li>
                    <li>Sublicense or transfer your access rights</li>
                    <li>Remove or modify proprietary notices</li>
                </ul>
                
                <h2>7. Reporting Violations</h2>
                
                <p>
                    If you become aware of any unauthorized copying, cloning, or distribution of TechElliptica 
                    Apps, please report it immediately to our legal department.
                </p>
                
                <div class="info-box">
                    <strong>📞 Contact Details:</strong><br>
                    Check contact details on <a href="https://techelliptica.com/aboutus.php" target="_blank">https://techelliptica.com/aboutus.php</a><br>
                    <strong>Subject:</strong> "Intellectual Property Violation Report"
                </div>
                
                <h2>8. Disclaimer of Warranties</h2>
                
                <p>
                    The Apps are provided "AS IS" without warranties of any kind, either express or implied. 
                    TechElliptica does not warrant that the Apps will be error-free, secure, or uninterrupted.
                </p>
                
                <h2>9. Limitation of Liability</h2>
                
                <p>
                    To the maximum extent permitted by law, TechElliptica shall not be liable for any indirect, 
                    incidental, special, consequential, or punitive damages arising from your use of the Apps.
                </p>
                
                <h2>10. Governing Law</h2>
                
                <p>
                    These Terms shall be governed by and construed in accordance with the laws of India, 
                    without regard to its conflict of law provisions. Any legal action or proceeding arising 
                    under these Terms shall be brought exclusively in the courts located in India.
                </p>
                
                <h2>11. Modifications to Terms</h2>
                
                <p>
                    TechElliptica reserves the right to modify these Terms at any time. Continued use of the 
                    Apps after changes constitutes acceptance of the modified Terms.
                </p>
                
                <h2>12. Contact Information</h2>
                
                <div class="info-box">
                    <strong>TechElliptica</strong><br>
                    Office: 119, Mainland Hub, Keshnand Road, Wagholi - 412207, Pune, Maharashtra, INDIA<br>
                    Website: <a href="https://techelliptica.com">www.techelliptica.com</a><br>
                    Phone: +91-9764326834<br>
                    <strong>Full Contact Details:</strong> <a href="https://techelliptica.com/aboutus.php" target="_blank">https://techelliptica.com/aboutus.php</a>
                </div>
                
                <div class="important-box" style="margin-top: 40px;">
                    <strong>🔒 PROTECTION NOTICE:</strong> This application and all TechElliptica properties are 
                    protected by copyright, trademark, and other intellectual property laws. Unauthorized use, 
                    reproduction, or distribution will be prosecuted to the fullest extent of the law.
                </div>
                
                <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid #DFE1E6; text-align: center; color: #6B778C;">
                    <p style="font-size: 13px; margin-bottom: 10px;">
                        By using TechElliptica Apps, you acknowledge that you have read, understood, and agree 
                        to be bound by these Terms and Conditions.
                    </p>
                    <p style="font-size: 12px; margin-top: 20px;">
                        © 2025 TechElliptica. All Rights Reserved.<br>
                        Trademark and Copyright Protected
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php include $basedir.'parts/js.php';?>
	<?php include $basedir.'parts/teche-bottom.php';?>
	<?php include $basedir.'parts/footer.php';?>

</body>
</html>


