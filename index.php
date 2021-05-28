<?php include "includes/header.php"; ?>



<main>
    <div class="jumbotron">
        <video class="bg-video" src="assets/videos/james_harden.mp4" autoplay muted loop></video>
        <h4>Rejoins notre communauté !</h4>
        <h1>MyTeam <span class="orange stroke-text">Fantasy</span> Club</h1>
        <div class="jumbo-buttons">
            <button class="jumbo-button fill">S'abonner</button>
            <button class="jumbo-button stroke-button">Visitez le magasin</button>
        </div>
    </div>
         <script async src="https://www.googletagmanager.com/gtag/js?id=G-H8JVDM1LW3"></script>
         <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

          gtag('config', 'G-H8JVDM1LW3');
         </script>
         </main>

<! - PushAlert ->
        <script type = "text / javascript">
                (fonction (d, t) {
                        var g = d.createElement (t),
                        s = d.getElementsByTagName (t) [0];
                        g.src = "https://cdn.pushalert.co/integrate_3b330f65d63c44e229cecf8692dd3a4c.js";
                        s.parentNode.insertBefore (g, s);
                } (document, "script"));
        </script>
        <! - Fin de PushAlert ->
<?php print_r($_SESSION); ?>


<?php include "includes/footer.php"; ?>
