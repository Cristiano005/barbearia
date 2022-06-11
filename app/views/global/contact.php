<section class="bg-light m-3 p-4">
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
                                    <?php foreach ($hourly as $hour) : ?>
                                          <option> <?= date("d-m-Y H:i:s", strtotime($hour['hours'])); ?> </option>
                                    <?php endforeach; ?>
                              </select>
                        </div>
                        <div class="col-md-4">
                              <label for="inputState" class="form-label">Payment methods</label>
                              <select id="inputState" class="form-select border-dark" name="payment">
                                    <?php foreach ($payments as $payment) : ?>
                                          <option> <?= $payment['name'] ?> </option>
                                    <?php endforeach; ?>
                              </select>
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
<section class="bg-light shadow-lg d-flex flex-column p-4">
      <div class="title">
            <h3 class="text-primary text-center"> Our location: </h3>
      </div>
      <div class="d-flex justify-content-center" id="location">
            <img src="assets/img/location.jpg" class="img-fluid rounded" id="location-image" alt="Imagem de uma pessoas segurando o celular com o maps">
            <iframe 
              class="w-100 rounded" style="height: 30rem"
              src=
              "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1839.0303176614502!2d-47.314947!3d-22.800217!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c89841a711fbe5%3A0xb51070624ceb67d5!2sR.%20Jequitib%C3%A1s%2C%20860%20-%20Jardim%20Capoava%2C%20Nova%20Odessa%20-%20SP%2C%2013460-000!5e0!3m2!1spt-BR!2sbr!4v1654339123229!5m2!1spt-BR!2sbr" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
      </div>
</section>