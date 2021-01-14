<?php
requireTemplate('partials/head'); 
requireTemplate('partials/navigation');
?>


<div class="container profile">
    <div class="row">
        <div class="col-12">
            <section class="cover clearfix" style="background-image: url('/images/cover.jpg');">

            </section>
        </div>
    </div>
    <div class="profile_content">
        <div class="row">
            <div class="col-md-4">
                <aside class="profile_details">
                    <div class="profile_details_card card bg-dark">
                        <img src="/images/profile.jpeg" class="card-img-top rounded-circle p-1" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            <li class="list-group-item">Vestibulum at eros</li>
                        </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <h2>COntent</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php requireTemplate('partials/footer'); ?>
