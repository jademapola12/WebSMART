<style>
    body.blanked {
        background: white !important;
        color: black !important;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    #countdown {
        font-size: 24px;
        margin-top: 10px;
    }
</style>

<script>
    console.log("Page ready.");

    // Common blank-and-reload function
    function triggerBlankAndReload() {
      console.warn("Screenshot shortcut detected! Blanking the page...");
      document.body.classList.add('blanked');
      document.body.innerHTML = `
        <h1>Cannot take a screenshot!</h1>
        <div id="countdown">Reloading in 3...</div>
      `;
      navigator.clipboard.writeText('').catch(() => {});
      let seconds = 3;
      const countdownEl = document.getElementById('countdown');
      const timer = setInterval(() => {
        seconds--;
        countdownEl.textContent = `Reloading in ${seconds}...`;
        if (seconds <= 0) {
          clearInterval(timer);
          location.reload();
        }
      }, 1000);
    }

    // Disable right-click
    document.addEventListener("contextmenu", e => {
      e.preventDefault();
      console.warn("Right-click is disabled!");
    });

    // Block F12, Ctrl+P, Ctrl+S, Ctrl+Shift+S
    document.addEventListener("keydown", e => {
      if (
        e.key === "F12" ||
        (e.ctrlKey && (e.key.toLowerCase() === 'p' || e.key.toLowerCase() === 's')) ||
        (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 's')
      ) {
        e.preventDefault();
        console.warn("That shortcut is disabled!");
      }
    });

    // Detect PrintScreen or Shift+S
    document.addEventListener("keyup", e => {
      if (e.key === "PrintScreen" ||
          (e.shiftKey && e.key.toLowerCase() === 's')
      ) {
        triggerBlankAndReload();
      }
    });
  </script>

<?php 
    // Generate CSRF token if not set 
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// Assuming user_id is available in the session, e.g. "student1" or "student2"
$user_id = $_SESSION['user_id']; // Make sure user_id is stored in session upon login

if (isset($_GET['id']) && $_GET['id'] > 0 && isset($user_id)) {
    $archiveId = intval($_GET['id']); // Sanitize the input for safety

    // Make sure the 'viewed_archives' session variable is set as an array
    if (!isset($_SESSION['viewed_archives']) || !is_array($_SESSION['viewed_archives'])) {
        $_SESSION['viewed_archives'] = []; // Initialize if not set
    }

    // Ensure that the current user's entry is an array.
    if (!isset($_SESSION['viewed_archives'][$user_id]) || !is_array($_SESSION['viewed_archives'][$user_id])) {
        $_SESSION['viewed_archives'][$user_id] = []; // Initialize for this user if not set or not an array
    }

    // Check if the archiveId is already in the user's viewed archives
    if (!in_array($archiveId, $_SESSION['viewed_archives'][$user_id])) {
        // Increment the views_count in the database if the user has not viewed this archive before
        $conn->query("UPDATE archive_list SET views_count = views_count + 1 WHERE id = '$archiveId'");

        // Add this archive id to the session to track that the user has viewed it
        $_SESSION['viewed_archives'][$user_id][] = $archiveId;
    }

    // Query to get the archive details
    $qry = $conn->query("SELECT a.* FROM `archive_list` a WHERE a.id = '$archiveId'");
    if ($qry->num_rows) {
        // Fetch the data and store it in variables
        foreach ($qry->fetch_array() as $k => $v) {
            if (!is_numeric($k)) $$k = $v;
        }
    }
}


if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT a.* FROM `archive_list` a where a.id = '{$_GET['id']}'");
    if($qry->num_rows){
        $row = $qry->fetch_assoc();
        $act_year = $row['year'];
        $type = $row['type'];
        $style = $row['style'];
        $tag = $row['tag'];
        $keywords = $row['keywords'];
        $agenda = $row['agenda'];
    }
    
    $sql1 = "SELECT * FROM research_type WHERE id = '$type'";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);

    $sql2 = "SELECT * FROM reference_style WHERE id = '$style'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
}
?>



<style>
    #document_field, #abstract_field {
        min-height: 80vh;
    }
    .filters {
        margin-top: -50px;
    }
    .droppy{
        overflow: scroll;
        height: 40vh;
    }
    #document_field, #abstract_field {
    width: 100%;
    min-height: 80vh;
    }
    /* Style for the PDF container */
.pdf-container {
    width: 100%;
    max-height: 600px; /* Limit height if needed */
    overflow-y: auto; /* Enable scrolling */
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    position: relative;
}

/* Disable user selection and interaction */
.pdf-container canvas {
    display: block;
    margin: 0 auto;
    user-select: none; /* Disable text selection */
    pointer-events: none; /* Disable interaction */

    @media (max-width: 768px) {
        #document_field, #abstract_field {
            height: 60vh; /* Reduce the height for smaller screens */
        }
    }

    @media (max-width: 480px) {
        #document_field, #abstract_field {
            height: 50vh; /* Further reduce height for very small screens */
        }
    }
}
</style>
<div class="content py-2">
<div class="row filters mt-3">
        <div class="col">
            <ul class="nav">
                    <li class="nav-item"><a href="?page=projects" class="nav-link text-dark font-weight-bold">All Projects</a></li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= isset($page) && $page == 'projects_per_department' ? 'active' : '' ?>" style="color: black; font-weight: 500;">Department</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow droppy">
                        <?php 
                        $departments = $conn->query("SELECT * FROM department_list WHERE status = 1 ORDER BY `name` ASC");
                        while($row = $departments->fetch_assoc()):
                        ?>
                        <li><a href="./?page=projects_per_department&id=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['name']) ?></a></li>
                        <?php if($departments->num_rows > 1): ?>
                        <li class="dropdown-divider"></li>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= isset($page) && $page == 'projects_per_curriculum' ? 'active' : '' ?>" style="color: black; font-weight: 500;">Courses</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow droppy">
                        <?php 
                        $curriculums = $conn->query("SELECT * FROM curriculum_list WHERE status = 1 ORDER BY `name` ASC");
                        while($row = $curriculums->fetch_assoc()):
                        ?>
                        <li><a href="./?page=projects_per_curriculum&id=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['name']) ?></a></li>
                        <?php if($curriculums->num_rows > 1): ?>
                        <li class="dropdown-divider"></li>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenuYear" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= isset($page) && $page == 'projects_per_year' ? 'active' : '' ?>" style="color: black; font-weight: 500;">Year</a>
                    <ul aria-labelledby="dropdownSubMenuYear" class="dropdown-menu border-0 shadow droppy">
                        <?php
                        $currentYear = date("Y");
                        for ($year = $currentYear; $year >= ($currentYear - 20); $year--) {
                            echo '<li><a href="./?page=projects_per_year&year=' . $year . '" class="dropdown-item">' . $year . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= isset($page) && $page == 'projects_per_type' ? 'active' : '' ?>" style="color: black; font-weight: 500;">Research Type</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow droppy">
                        <?php 
                        $curriculums = $conn->query("SELECT * FROM research_type ORDER BY `type` ASC");
                        while($row = $curriculums->fetch_assoc()):
                        ?>
                        <li><a href="./?page=projects_per_type&id=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['type']) ?></a></li>
                        <?php if($curriculums->num_rows > 1): ?>
                        <li class="dropdown-divider"></li>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= isset($page) && $page == 'projects_per_style' ? 'active' : '' ?>" style="color: black; font-weight: 500;">Reference Style</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow droppy">
                        <?php 
                        $curriculums = $conn->query("SELECT * FROM reference_style ORDER BY `style` ASC");
                        while($row = $curriculums->fetch_assoc()):
                        ?>
                        <li><a href="./?page=projects_per_style&id=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['style']) ?></a></li>
                        <?php if($curriculums->num_rows > 1): ?>
                        <li class="dropdown-divider"></li>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="col-md-4 col-sm-12">
            <form class="w-100" id="search-form" method="GET" action="./">
                <input type="hidden" name="page" value="projects">
                <input style="height: 50px;" type="search" id="search-input" name="q" class="form-control rounded-5" required placeholder="Search..." value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                <div id="suggestions-box" style="position: relative;">
                    <ul id="suggestions-list" class="list-group" style="position: absolute; z-index: 1000; width: 100%;">
                    </ul>
                </div>
            </form>
        </div>

        <script>
    document.getElementById('suggestions-list').style.display = 'none';
    document.getElementById('search-input').addEventListener('input', function () {
        let query = this.value.trim();

        if (query.length > 0) {
            fetch(`search_suggestions.php?q=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(data => {
                    const suggestionsList = document.getElementById('suggestions-list');
                    suggestionsList.innerHTML = data.trim() !== '' ? data : '';
                    suggestionsList.style.display = data.trim() !== '' ? 'block' : 'none';

                    // Update search count
                    fetch('update_search_count.php');
                });
        } else {
            document.getElementById('suggestions-list').innerHTML = '';
            document.getElementById('suggestions-list').style.display = 'none';
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.matches('.suggestion-item')) {
            // Extract the title from the data-title attribute
            const selectedTitle = e.target.getAttribute('data-title');
            document.getElementById('search-input').value = selectedTitle;

            // Automatically submit the form to trigger the search
            document.getElementById('search-form').submit();
        }
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('suggestions-box').contains(e.target)) {
            document.getElementById('suggestions-list').innerHTML = '';
            document.getElementById('suggestions-list').style.display = 'none';
        }
    });
</script>

    </div>
    <div class="col-12 mt-3">
    <div class="card card-outline card-success shadow rounded-0">
        <div class="card-body rounded-0">
            <div class="container-fluid">
                <h2><b><?= isset($title) ? $title : "" ?></b></h2>
                <small class="text-muted">Submitted by <b class="text-info"><?= $submitted_by ?></b> on  <?= date("F d, Y h:i A",strtotime($date_created)) ?></small>
                
                <?php if(isset($student_id) && $_settings->userdata('login_type') == "2" && $student_id == $_settings->userdata('id')): ?>
                    <div class="form-group">
                        <a href="./?page=submit-archive&id=<?= isset($id) ? $id : "" ?>" class="btn btn-flat btn-default bg-navy btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <button type="button" data-id = "<?= isset($id) ? $id : "" ?>" class="btn btn-flat btn-danger btn-sm delete-data"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                <?php endif; ?>
                
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Research Type:</legend>
                            <div class="pl-4"><large><?= isset($type) ? htmlspecialchars($row1['type']) : "----" ?></large></div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Reference Style:</legend>
                            <div class="pl-4"><large><?= isset($style) ? htmlspecialchars($row2['style']) : "----" ?></large></div>
                        </fieldset>
                    </div> 
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Project Year:</legend>
                            <div class="pl-4"><large><?= isset($act_year) ? htmlspecialchars($act_year) : "----" ?></large></div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Tag(s):</legend>
                            <div class="pl-4"><large><?= isset($tag) ? html_entity_decode($tag) : "" ?></large></div>
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Members:</legend>
                            <div class="pl-4"><large><?= isset($members) ? html_entity_decode($members) : "" ?></large></div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Keywords</legend>
                            <div class="pl-4"><large><?= isset($keywords) ? html_entity_decode($keywords) : "" ?></large></div>
                        </fieldset>
                    </div>
                </div>
                
                <div class="col-md-6">
                        <fieldset>
                            <legend class="text-navy">Research Agenda</legend>
                            <div class="pl-4"><large><?= isset($agenda) ? html_entity_decode($agenda) : "" ?></large></div>
                        </fieldset>
                    </div>
                </div>     
                    <br><br>
                <fieldset>
                    <legend class="text-navy">Abstract:</legend>
                    <div class="pl-4 pdf-container">
                        <div id="abstract_pdf_render"></div>
                    </div>
                </fieldset>

                <?php if ($_settings->userdata('id') > 0): ?>
                    <fieldset>
                        <legend class="text-navy">Project Document:</legend>
                        <div class="pl-4 pdf-container">
                            <div id="document_pdf_render"></div>
                        </div>
                    </fieldset>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</div>
    <!-- Include PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
            // Function to render PDF as images
            async function renderPDF(pdfURL, containerID) {
                const container = document.getElementById(containerID);
            
                if (!container) return;
            
                // Load the PDF
                const pdf = await pdfjsLib.getDocument(pdfURL).promise;
            
                // Render each page of the PDF
                for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                    const page = await pdf.getPage(pageNum);
            
                    // Create a canvas element for each page
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    const viewport = page.getViewport({ scale: 1.5 }); // Adjust scale for higher quality
            
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
            
                    // Render the page onto the canvas
                    await page.render({ canvasContext: context, viewport }).promise;
            
                    // Append the canvas to the container
                    container.appendChild(canvas);
                }
            }
            
            // URLs for the PDFs
            const abstractPDF = "<?= isset($abstract) ? base_url.$abstract : '' ?>";
            const documentPDF = "<?= isset($document_path) ? base_url.$document_path : '' ?>";
            
            // Render the PDFs
            if (abstractPDF) {
                renderPDF(abstractPDF, 'abstract_pdf_render');
            }
            if (documentPDF) {
                renderPDF(documentPDF, 'document_pdf_render');
            }
            
    $(function(){
        $('.delete-data').click(function(){
            _conf("Are you sure to delete <b>Archive-<?= isset($archive_code) ? $archive_code : "" ?></b>","delete_archive")
        })
    })
    function delete_archive(){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_archive",
            method:"POST",
            data:{id: "<?= isset($id) ? $id : "" ?>"},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.replace("./");
                }else{
                    alert_toast("An error occured.",'error');
                    end_loader();
                }
            }
        })
    }
    
</script>