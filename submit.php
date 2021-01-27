<?php require __DIR__ . '/views/header.php'; ?>

<main>




    <section class="create-post">
        <hi>CREATE A NEW POST</hi>

    <form action="/submit.php" method="post">
    <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control save" type="title" name="title" id ="title" placeholder="Enter title" required>
    </div>

    <div class="form-group">
        <label for="link">URL</label>
        <input class="form-control" type="link" name="link" id ="link" placeholder="Enter URL" required>
    </div>

    <div class="form-group">
        <label for="description">Comment <small class="text-muted"><i> - - Optional</i></small></label> 
        <textarea class="form-control" type="text" name="description" id ="description" placeholder="Enter description"></textarea>
    </div>

    <button type="submit" class="btn" id="log-in-btn">SUBMIT</button>
    </form>

    </section>

    


</main>





<?php require __DIR__ . '/views/footer.php'; ?>