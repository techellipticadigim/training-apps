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

$pageNumber = getOptionalGET("page",1);
validateIntParam($pageNumber);

$start = ($pageNumber-1)*10;

// Get search query if exists
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query with search filter
if (!empty($searchQuery)) {
    $searchTerm = '%' . $searchQuery . '%';
    $query = "SELECT * FROM `APPS` WHERE APPSTATUS = 'ACTIVE' 
              AND (APPNAME LIKE ? OR APPDESC LIKE ? OR APPTAGS LIKE ?) 
              ORDER BY PUBLISHEDDATE DESC LIMIT $start, 10";
    $arr = array($searchTerm, $searchTerm, $searchTerm);
    $allCalls = selectPData($query, "sss", $arr);
} else {
    $query = "SELECT * FROM `APPS` WHERE APPSTATUS = 'ACTIVE' ORDER BY PUBLISHEDDATE DESC LIMIT $start, 10";
    $allCalls = selectData($query);
}

$topicValue = "All Apps"
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Techelliptica All Learning Apps | Learn with Visualization</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Explore expert-written blogs on QA testing, Full Stack Development, Selenium, Java, Spring Boot, React, and career tips. Stay updated with Techelliptica insights.">
<meta name="keywords" content="QA blog, software testing blog, full stack development blog, selenium tutorials, java spring boot blog, react development articles, automation testing tips, manual testing guides, QA interview questions, mock interview tips, software testing assignments, full stack projects, techelliptica blog, QA training tips, coding best practices, developer blog, QA tools blog, career advice for testers, software development blog">
<meta name="author" content="Tech Elliptica">

<?php include $basedir.'parts/quilljs-top.php';?>
<?php include $basedir.'parts/ico.php';?>
<?php include $basedir.'parts/css.php';?>
<?php include $basedir.'parts/page-responsive-head.php';?>
<?php include $basedir.'parts/quilljs-bottom.php';?>

<style>
/* Jira-inspired Color Scheme for app-container only */
:root {
    --jira-blue: #0052CC;
    --jira-blue-dark: #0747A6;
    --jira-blue-light: #DEEBFF;
    --jira-text-primary: #172B4D;
    --jira-text-secondary: #5E6C84;
    --jira-border: #DFE1E6;
    --jira-bg: #F4F5F7;
    --jira-card-bg: #FFFFFF;
    --jira-hover: #FAFBFC;
}

html {
    scroll-behavior: smooth;
}

.app-cards-container {
    scroll-margin-top: 20px;
    position: relative;
}

.app-cards-container.focused {
    animation: focusPulse 1s ease-in-out;
}

@keyframes focusPulse {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 82, 204, 0);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(0, 82, 204, 0.15);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 82, 204, 0);
    }
}

.app-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 24px;
    border-radius: 3px;
}

.app-card {
    background: var(--jira-card-bg);
    border-radius: 3px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    margin-bottom: 16px;
    border: 1px solid var(--jira-border);
    transition: all 0.2s ease;
}

.app-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    border-color: #B3BAC5;
}

.app-card-content {
    display: flex;
    gap: 24px;
    padding: 24px;
    flex-wrap: wrap;
}

.app-info {
    flex: 1;
    min-width: 300px;
}

.app-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--jira-text-primary);
    margin-bottom: 12px;
    line-height: 1.4;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
}

.app-description {
    font-size: 14px;
    color: var(--jira-text-secondary);
    line-height: 1.6;
    margin-bottom: 16px;
    text-align: justify;
}

.app-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 12px;
}

.app-tag {
    background: var(--jira-blue-light);
    color: var(--jira-blue-dark);
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    transition: background 0.2s ease;
    letter-spacing: 0.3px;
}

.app-tag:hover {
    background: #B3D4FF;
}

.app-media {
    margin-top: 50px;
    flex-basis: 320px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.app-image-wrapper {
    width: 100%;
    height: 180px;
    border-radius: 3px;
    overflow: hidden;
    border: 1px solid var(--jira-border);
    background: var(--jira-bg);
}

.app-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.2s ease;
}

.app-card:hover .app-image-wrapper img {
    opacity: 0.9;
}

.app-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 12px;
    background: var(--jira-hover);
    border-radius: 3px;
}

.app-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--jira-text-secondary);
    font-weight: 500;
}

.app-meta-icon {
    width: 16px;
    height: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--jira-blue);
}

.app-action {
    margin-top: 8px;
}

.app-button {
    background: var(--jira-blue);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 3px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s ease;
    width: 100%;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
}

.app-button:hover {
    background: var(--jira-blue-dark);
}

.app-button:active {
    background: #003884;
}

.app-divider {
    display: none;
}

.filter-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--jira-blue);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 3px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s ease;
    margin-bottom: 16px;
}

.filter-toggle-btn:hover {
    background: var(--jira-blue-dark);
}

.filter-toggle-btn .toggle-icon {
    transition: transform 0.3s ease;
}

.filter-toggle-btn.active .toggle-icon {
    transform: rotate(180deg);
}

.search-section {
    margin-bottom: 24px;
    background: var(--jira-card-bg);
    padding: 24px;
    border-radius: 3px;
    border: 2px solid var(--jira-blue);
    box-shadow: 0 1px 1px rgba(9, 30, 66, 0.25);
    display: none;
    animation: slideDown 0.3s ease-out;
}

.search-section.active {
    display: block;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.search-header {
    text-align: center;
    color: var(--jira-text-primary);
    margin-bottom: 16px;
}

.search-header h2 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 4px;
    color: var(--jira-text-primary);
}

.search-header p {
    font-size: 13px;
    color: var(--jira-text-secondary);
}

.search-form {
    display: flex;
    gap: 8px;
    max-width: 700px;
    margin: 0 auto;
}

.search-input-wrapper {
    flex: 1;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 10px;
    top: 44%;
    transform: translateY(-50%);
    font-size: 21px;
    color: var(--jira-text-secondary);
    pointer-events: none;
}

.search-input {
    width: 80% !important;
    height: 40px !important;
    padding: 8px 30px 8px 32px;
    padding-left: 40px !important;
    border: 2px solid var(--jira-border);
    border-radius: 3px;
    font-size: 20px !important;
    outline: none;
    transition: all 0.2s ease;
    background: var(--jira-hover);
    color: var(--jira-text-primary);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
}

.search-input:focus {
    border-color: var(--jira-blue);
    background: white;
}

.search-loading {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: none;
}

.search-loading.active {
    display: block;
}

.spinner {
    border: 2px solid var(--jira-border);
    border-top: 2px solid var(--jira-blue);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.search-active-badge {
    text-align: center;
    background: var(--jira-blue-light);
    padding: 8px 12px;
    border-radius: 3px;
    margin-top: 12px;
    display: inline-block;
    color: var(--jira-blue-dark);
    font-weight: 600;
    font-size: 12px;
}

.results-summary {
    text-align: left;
    margin-bottom: 16px;
    font-size: 14px;
    color: var(--jira-text-secondary);
    font-weight: 500;
    padding: 8px 0;
    scroll-margin-top: 20px;
}

.no-results {
    text-align: center;
    padding: 48px 24px;
    background: var(--jira-card-bg);
    border-radius: 3px;
    border: 1px solid var(--jira-border);
}

.no-results-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.4;
}

.no-results h3 {
    font-size: 18px;
    color: var(--jira-text-primary);
    margin-bottom: 8px;
    font-weight: 600;
}

.no-results p {
    font-size: 14px;
    color: var(--jira-text-secondary);
}

@media (max-width: 768px) {
    .app-card-content {
        flex-direction: column;
        padding: 16px;
    }
    
    .app-media {
        flex-basis: 100%;
    }
    
    .app-title {
        font-size: 18px;
    }
    
    .search-form {
        flex-direction: column;
    }
    
    .search-btn,
    .clear-btn {
        width: 100%;
    }
    
    .app-container {
        padding: 12px;
    }
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
                        <li style="display: inline;"><a href="<?php echo getHost() ?>/apps/all" style="color: #2a1379; text-decoration: none;">All Apps</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
			<div class="span12">
                <h2>All Learning Apps</h2>
			</div>
		</div>
		
        
        <div class="app-container">
            <!-- Filter Toggle Button -->
            <button class="filter-toggle-btn" style="float:right;" id="filterToggleBtn" onclick="toggleFilter()">
                <span class="toggle-icon">▼</span>
                <span id="filterBtnText">Show Filters</span>
            </button>
            
            <!-- Search Section -->
            <div class="search-section" id="searchSection">
                <div class="search-header">
                    <h2>🔍 Explore Learning Apps</h2>
                    <p>Search by app name, description, or tags</p>
                </div>
                <div class="search-form">
                    <div class="search-input-wrapper">
                        <span class="search-icon">🔎</span>
                        <input type="text" 
                               id="liveSearchInput"
                               class="search-input" 
                               placeholder="Start typing to filter apps..."
                               value="<?php echo htmlspecialchars($searchQuery); ?>"
                               autocomplete="off">
                        <div class="search-loading" id="searchLoading">
                            <div class="spinner"></div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($searchQuery)): ?>
                    <div style="text-align: center; margin-top: 12px;">
                        <div class="search-active-badge" style="display: inline-flex; align-items: center; gap: 10px;">
                            <span>🎯 Filtering: "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</span>
                            <button onclick="clearSearch()" style="background: transparent; border: none; color: var(--jira-blue-dark); cursor: pointer; font-weight: bold; font-size: 16px; padding: 0 4px;" title="Clear search">✕</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Results Summary -->
            <?php if (!empty($allCalls)): ?>
                <div class="results-summary" id="results-summary">
                    Found <strong><?php echo count($allCalls); ?></strong> app<?php echo count($allCalls) != 1 ? 's' : ''; ?>
                    <?php if (!empty($searchQuery)): ?>
                        matching your search
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- App Cards -->
            <?php if (empty($allCalls)): ?>
                <div class="no-results">
                    <div class="no-results-icon">🔍</div>
                    <h3>No apps found</h3>
                    <p>
                        <?php if (!empty($searchQuery)): ?>
                            No apps match your search "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>". Try different keywords.
                        <?php else: ?>
                            No apps are currently available.
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="app-cards-container" id="results">
                <?php foreach($allCalls as $call): ?>
                <div class="app-card">
                    <div class="app-card-content">
                        <div class="app-info">
                            <h2 class="app-title"><?php echo htmlspecialchars($call["APPNAME"]) ?></h2>
                            
                            <div class="app-description">
                                <?php echo urldecode($call['APPDESC']) ?>
                            </div>
                            
                            <div class="app-tags">
                                <?php
                                    $ar = explode(",", $call['APPTAGS']);
                                    foreach($ar as $tag){
                                        $tag = trim($tag);
                                        if($tag != ""){
                                ?>
                                    <span class="app-tag">#<?php echo htmlspecialchars($tag) ?></span>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="app-media">
                            <div class="app-image-wrapper">
                                <img src="../<?php echo htmlspecialchars($call["APPIMAGE"]) ?>" 
                                     alt="<?php echo htmlspecialchars($call["APPNAME"]) ?>">
                            </div>
                            
                            <div class="app-meta">
                                <div class="app-meta-item">
                                    <span class="app-meta-icon">📅</span>
                                    <span>Published on <?php echo date("d-M-Y", strtotime($call["PUBLISHEDDATE"])) ?></span>
                                </div>
                                <div class="app-meta-item">
                                    <span class="app-meta-icon">👨‍💻</span>
                                    <span>Developed by <?php echo htmlspecialchars($call["CREATEDBY"]) ?></span>
                                </div>
                            </div>
                            
                            <div class="app-action">
                                <button class="app-button" onclick="window.open('<?php echo htmlspecialchars($call["REDIRECT"]) ?>', '_blank')">
                                    Launch App →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="span12" style="height:100px;text-align:center;">
                <div class="pagination-panel" elm-id="pagination-panel" style="display:flex;align-items: center;justify-content: center;">
                    <?php
                        $prevPageNumber = 1;
                        $nextPageNumber = 2;
                        if($pageNumber < 2){
                            $prevPageNumber = 1;
                         }else{
                            $prevPageNumber = $pageNumber -1;
                            $nextPageNumber = $pageNumber +1;
                         }
                        // Build query string for pagination
                        $queryString = !empty($searchQuery) ? '&search=' . urlencode($searchQuery) : '';
                     ?>
                     <div style="border:1px solid black;height:30px;line-height:30px;padding-left:10px;padding-right:10px;"><a style="text-decoration:none;"  href="all?page=1<?php echo $queryString ?>">Latest</a></div>
                    <div style="border:1px solid black;height:30px;line-height:30px;padding-left:10px;padding-right:10px;"><a style="text-decoration:none;"  href="all?page=<?php echo $prevPageNumber ?><?php echo $queryString ?>">Prev</a></div>

                     <?php
                        $startPageNumber = $pageNumber -4;
                        if($startPageNumber < 1){
                            $startPageNumber = 1;
                            $endPageNumber = 9;
                        }else{
                            $endPageNumber = $startPageNumber + 9;
                        }

                        for($i = $startPageNumber; $i < $endPageNumber ; $i++){
                      if($pageNumber == $i){ ?>
                        <div style="height:30px;line-height:30px;padding-left:10px;padding-right:10px;"><a style="text-decoration:none; font-size:20px;color:black;font-weight:800;" href="all?page=<?php echo $i ?><?php echo $queryString ?>"> <?php echo $i ?></a></div>
                      <?php }else{ ?>
                        <div style="height:30px;line-height:30px;padding-left:10px;padding-right:10px;"><a style="text-decoration:none;" href="all?page=<?php echo $i ?><?php echo $queryString ?>"> <?php echo $i ?></a></div>
                      <?php } ?>

                    <?php } ?>

                    <div style="border:1px solid black;height:30px;line-height:30px;padding-left:10px;padding-right:10px;"><a style="text-decoration:none;"  href="all?page=<?php echo $nextPageNumber ?><?php echo $queryString ?>">Next</a></div>
                </div>
            </div>
        </div>
</div>

        <?php include $basedir.'parts/js.php';?>
		<?php include $basedir.'parts/teche-bottom.php';?>
		<?php include $basedir.'parts/footer.php';?>

		<script>
		    $(".daycounter").each(function($elm){
		        $date2Str = $(this).attr("date-value");
		        const date1 = new Date();
                const date2 = new Date($date2Str);
                const diffTime = Math.abs(date2 - date1);


                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                const diffHours = Math.floor(diffTime / (1000 * 60 * 60));
                const diffMinutes = Math.floor(diffTime / (1000 * 60));
                console.log(diffDays + " - " + diffHours + " - " + diffMinutes);
                if(diffDays != 0){
                    $(this).html("("+diffDays + " Day(s) ago"+")");
                }else if(diffHours != 0){
                    $(this).html("("+diffHours + " Hour(s) ago"+")");
                }else if(diffMinutes != 0){
                     $(this).html("("+diffMinutes + " Minute(s) ago"+")");
                }
		    });
		    
		    // Clear Search Function
		    function clearSearch() {
		        const url = new URL(window.location.href);
		        url.searchParams.delete('search');
		        url.searchParams.set('page', '1');
		        window.location.href = url.toString();
		    }
		    
		    // Toggle Filter Function
		    function toggleFilter() {
		        const searchSection = document.getElementById('searchSection');
		        const toggleBtn = document.getElementById('filterToggleBtn');
		        const btnText = document.getElementById('filterBtnText');
		        
		        if (searchSection.classList.contains('active')) {
		            searchSection.classList.remove('active');
		            toggleBtn.classList.remove('active');
		            btnText.textContent = 'Show Filters';
		        } else {
		            searchSection.classList.add('active');
		            toggleBtn.classList.add('active');
		            btnText.textContent = 'Hide Filters';
		            
		            // Focus on search input when filter opens
		            setTimeout(function() {
		                const searchInput = document.querySelector('.search-input');
		                if (searchInput) {
		                    searchInput.focus();
		                }
		            }, 100);
		        }
		    }
		    
		    // Show filter section automatically if there's an active search
		    <?php if (!empty($searchQuery)): ?>
		    window.addEventListener('DOMContentLoaded', function() {
		        toggleFilter();
		        
		        // Scroll to results section after a short delay
		        setTimeout(function() {
		            // Try to scroll to results summary first, then cards container
		            const resultsSummary = document.getElementById('results-summary');
		            const resultsCards = document.getElementById('results');
		            const targetElement = resultsSummary || resultsCards;
		            
		            if (targetElement) {
		                // Add focused class for visual effect (only on cards container)
		                if (resultsCards) {
		                    resultsCards.classList.add('focused');
		                }
		                
		                // Scroll to target
		                targetElement.scrollIntoView({ 
		                    behavior: 'smooth', 
		                    block: 'start'
		                });
		                
		                // Remove focused class after animation
		                setTimeout(function() {
		                    if (resultsCards) {
		                        resultsCards.classList.remove('focused');
		                    }
		                }, 1000);
		            }
		        }, 400);
		    });
		    <?php endif; ?>
		    
		    // Live Search Implementation
		    const liveSearchInput = document.getElementById('liveSearchInput');
		    const searchLoading = document.getElementById('searchLoading');
		    let searchTimeout;
		    
		    if (liveSearchInput) {
		        liveSearchInput.addEventListener('input', function(e) {
		            const searchValue = e.target.value.trim();
		            
		            // Clear previous timeout
		            clearTimeout(searchTimeout);
		            
		            // Show loading spinner
		            searchLoading.classList.add('active');
		            
		            // Debounce: Wait 500ms after user stops typing
		            searchTimeout = setTimeout(function() {
		                searchLoading.classList.remove('active');
		                
		                // Build URL with search parameter
		                const url = new URL(window.location.href);
		                url.searchParams.set('page', '1'); // Reset to first page
		                
		                if (searchValue) {
		                    url.searchParams.set('search', searchValue);
		                } else {
		                    url.searchParams.delete('search');
		                }
		                
		                // Redirect to filtered URL
		                window.location.href = url.toString();
		            }, 500);
		        });
		        
		        // Also handle Enter key
		        liveSearchInput.addEventListener('keypress', function(e) {
		            if (e.key === 'Enter') {
		                e.preventDefault();
		                clearTimeout(searchTimeout);
		                
		                const searchValue = e.target.value.trim();
		                const url = new URL(window.location.href);
		                url.searchParams.set('page', '1');
		                
		                if (searchValue) {
		                    url.searchParams.set('search', searchValue);
		                } else {
		                    url.searchParams.delete('search');
		                }
		                
		                window.location.href = url.toString();
		            }
		        });
		        
		        // Clear search when Escape is pressed
		        liveSearchInput.addEventListener('keydown', function(e) {
		            if (e.key === 'Escape') {
		                e.preventDefault();
		                this.value = '';
		                
		                const url = new URL(window.location.href);
		                url.searchParams.delete('search');
		                url.searchParams.set('page', '1');
		                window.location.href = url.toString();
		            }
		        });
		    }
		</script>

</body>
</html>
   


