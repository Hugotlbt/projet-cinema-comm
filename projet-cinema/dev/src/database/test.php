<?php
require_once '../../base.php';
require_once BASE_PROJET . '/src/config/db-config.php';
require_once BASE_PROJET . '/src/database/commentaire-db.php';

$Users = getCommentaireFilms(1);
print_r($Users);
