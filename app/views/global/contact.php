<section class="bg-light m-3 p-4">
    <div class="d-flex justify-content-between align-items-center">
      <h1> Contato </h1> 
      <?php echo message("register", "success"); ?> 
    </div>
        <fieldset>
            <form action="/contact/store" method="POST" class="row g-3">
                  <div class="col-md-6">
                        <label for="inputText4" class="form-label">Nome</label>
                        <input type="text" name="name" class="form-control" id="inputTextl4" placeholder="Por favor, não digite apelidos">
                        <?php echo message("name"); ?>
                  </div>
                  <div class="col-md-4">
                        <label for="inputState" class="form-label">Horários</label>
                              <select id="inputState" class="form-select" name="date"> <!--  o name tem que estar no 'select'. -->
                                    <?php foreach($hourly as $hour): ?>
                                          <option> <?= date("d-m-Y H:i:s", strtotime($hour['hours'])); ?> </option>
                                    <?php endforeach; ?>
                              </select>
                  </div>
                  <div class="col-md-4">
                        <label for="inputState" class="form-label">Formas de pagamento</label>
                              <select id="inputState" class="form-select" name="payment">
                                    <?php foreach($payments as $payment): ?>
                                          <option> <?= $payment['name'] ?> </option>
                                    <?php endforeach; ?>
                              </select>
                  </div>
                  <div class="col-12">
                         <button type="submit" class="btn btn-primary">Confirmar agendamento</button>
                  </div>
            </form>
      </fieldset>
</section>