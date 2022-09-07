{extends 'template.php'}

{block main}

<section class=" bg-light d-flex flex-column align-items-center p-3" id="tableClients">
    <h2> Visualize todos os seus dados</h2>
    <div id="search">
        <div class="input-group mb-3">
            <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Opções</button>
            <ul class="dropdown-menu">
                <div class="d-flex flex-column align-items-center justify-content-around">
                    <li><a class="btn btn-outline-primary" href="/admin/home/clients">Clients</a></li>
                    <li><a class="btn btn-outline-primary m-3" href="/admin/home/hourly">Hourly</a></li>
                    <li><a class="btn btn-outline-primary" href="/admin/home/payment">Payment</a></li>
                </div>
            </ul>
            <input type="text" class="form-control" aria-label="Text input with dropdown button">
        </div>
    </div>
    <div class="container-fluid table-responsive">
        <table class="table table-bordered border-dark table-primary table-hover text-center" id="table">
            <thead>
                <?php foreach($limit[0] as $field => $value): ?>
                    <th> <?= $field ?> </th>
                <?php endforeach; ?>
                <th colspan="2"> Ações </th>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach($limit as $index => $values): ?>
                    <tr>
                        <?php foreach($values as $field => $value): ?>
                            <td> <?= $value ?> </td>    
                        <?php endforeach; ?>
                        <td>
                            <a href="update" class="btn btn-primary"> Edit </a>
                        </td>
                        <td>
                            <a href="destroy" class="btn btn-danger"> Deletar </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($_GET['page'] > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?="?page=".$pagination-1?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= ceil(count($data) / 5); $i++) : ?>
                    <li class="page-item">
                        <a class="page-link link-primary bg-dark text-light" href="<?="?page=".$i?>">
                            <?= $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
                <?php if ($_GET['page'] < 15 && count($data) > 5): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?="?page=".$pagination + 1?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</section>

{/block}