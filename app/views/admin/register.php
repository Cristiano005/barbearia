{extends 'template.php'}

{block main}

<section>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary"> Contact </h1>
        <?php echo message("register", "success"); ?>
    </div>
    <div class="card w-10 shadow-lg">
        <div class="card-body">
            <form action="/contact/store" method="POST" class="row g-3">
                <div class="col-md-6">
                    <label for="inputText4" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control border-dark" id="inputTextl4" placeholder="Por favor, não digite apelidos">
                    <?php echo message("name"); ?>
                </div>
                <div class="col-md-4">
                    <label for="inputState" class="form-label">Hourly</label>
                    <select id="inputState" class="form-select border-dark" name="hourly">
                        <!--  o name tem que estar no 'select'. -->
                      
                </div>
                <div class="col-md-4">
                    <label for="inputState" class="form-label">Payment methods</label>
                   
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">
                        Confirm Scheduling
                        <img class="bg-light rounded p-1" src="assets/img/person-check.svg" alt="Icone de confirmação">
                        </a>
                </div>
            </form>
        </div>
    </div>
</section>

{/block}