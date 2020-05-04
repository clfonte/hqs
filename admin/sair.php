<?php

//iniciar a sessão
session_start();

//apagar a sessão
session_unset();

//redirecionar para a página inicial
header('location: ./index.php');