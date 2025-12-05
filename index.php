<?php
include "connection.php";
$sqlAffichage = "SELECT * FROM animals, habitat where animals.habitat_id = habitat.id";

if (!empty($_POST["filterHabitat"])) {
    echo $_POST["filterHabitat"];
    $habitat = $_POST["filterHabitat"];
    $sqlAffichage .= " AND habitat_id = $habitat";
}

if (!empty($_POST["filterType"])) {
    $type = $_POST["filterType"];
    $sqlAffichage .= " AND type_alimentaire = '$type'";
}

if (isset($_POST["search-btn"]) && !empty($_POST["search"])) {
    $name_search = strtolower($_POST["search"]);
    $sqlAffichage .= " AND nom = '$name_search'";
}

$resultAffichage = mysqli_query($conn, $sqlAffichage);
$dataAffichage = mysqli_fetch_all($resultAffichage, MYSQLI_ASSOC);

$sqlCtrOm = "SELECT * FROM animals where type_alimentaire = '🍽️ Omnivore';";
$resultCtrOm = mysqli_query($conn, $sqlCtrOm);
$dataCtrOm = mysqli_fetch_all($resultCtrOm, MYSQLI_ASSOC);


$sqlCtrCar = "SELECT * FROM animals where type_alimentaire = '🥩 Carnivore';";
$resultCtrCar = mysqli_query($conn, $sqlCtrCar);
$dataCtrCar = mysqli_fetch_all($resultCtrCar, MYSQLI_ASSOC);


$sqlCtrHerb = "SELECT * FROM  animals where type_alimentaire = '🌿 Herbivore'";
$resultCtrHerb = mysqli_query($conn, $sqlCtrHerb);
$dataCtrHerb = mysqli_fetch_all($resultCtrHerb, MYSQLI_ASSOC);

$sqltotal = "SELECT * FROM animals;";
$resulttotal = mysqli_query($conn, $sqltotal);
$total = mysqli_fetch_all($resulttotal, MYSQLI_BOTH);

if (count($total) != 0) {
    $herbivore = (count($dataCtrHerb) / count($total)) * 100;
    $carnivore = (count($dataCtrCar) / count($total)) * 100;
    $omnivore = (count($dataCtrOm) / count($total)) * 100;
} else {
    $herbivore = 0;
    $carnivore = 0;
    $omnivore = 0;
}



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Animals - Apprendre en S'amusant</title>
    <style>
        .no-animals {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            font-size: 1.3em;
            font-weight: 600;
            color: #4a5568;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 40px;
            position: relative;
            left: 108%;
        }

        .valueHerb {
            background-color: green;
            height: 100%;
            border-radius: 30px;
        }

        .valueOmn {
            background-color: yellow;
            height: 100%;
            border-radius: 30px;
        }

        .valueCar {
            background-color: red;
            height: 100%;
            border-radius: 30px;
        }

        .range {
            height: 5px;
            background-color: rgba(173, 173, 173, 1);
            position: relative;
            top: 15px;
            border-radius: 30px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #2d3748;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #718096;
            font-size: 1.1em;
        }

        .lang-switcher {
            position: absolute;
            top: 30px;
            right: 30px;
            display: flex;
            gap: 10px;
        }

        .lang-btn {
            padding: 10px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #4a5568;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .lang-btn:hover {
            background: #f7fafc;
            border-color: #4299e1;
        }

        .lang-btn.active {
            background: #4299e1;
            color: white;
            border-color: #4299e1;
        }

        .filters {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 1em;
        }

        select,
        input {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            color: #4a5568;
        }

        select:hover,
        input:hover {
            border-color: #cbd5e0;
        }

        select:focus,
        input:focus {
            outline: none;
            border-color: #4299e1;
        }

        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            background: #4299e1;
            color: white;
            font-weight: 600;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn:hover {
            background: #3182ce;
        }

        .btn-add {
            background: #48bb78;
        }

        .btn-add:hover {
            background: #38a169;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #718096;
            font-size: 1em;
        }

        .animals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .animal-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            cursor: pointer;
        }

        .animal-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .animal-image {
            width: 100%;
            height: 200px;
            background: #edf2f7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5em;
            position: relative;
        }

        .animal-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.25em;
            font-weight: 600;
            color: #4a5568;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .animal-info {
            padding: 20px;
        }

        .animal-name {
            font-size: 1.6em;
            color: #2d3748;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .animal-detail {
            color: #4a5568;
            margin: 8px 0;
            font-size: 0.95em;
        }

        .animal-detail strong {
            color: #2d3748;
        }

        .animal-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-small {
            flex: 1;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #4299e1;
            color: white;
        }

        .btn-edit:hover {
            background: #3182ce;
        }

        .btn-delete {
            background: #f56565;
            color: white;
        }

        .btn-delete:hover {
            background: #e53e3e;
        }

        .btn-sound {
            background: #ed8936;
            color: white;
        }

        .btn-sound:hover {
            background: #dd6b20;
        }

        .game-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .game-title {
            font-size: 1.8em;
            color: #2d3748;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .game-card {
            display: inline-block;
            background: #edf2f7;
            border-radius: 12px;
            padding: 40px;
            font-size: 6em;
            margin: 20px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .game-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            .lang-switcher {
                position: static;
                justify-content: center;
                margin-top: 15px;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .animals-grid {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }

        .habitat-tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85em;
            margin-top: 5px;
            font-weight: 600;
        }

        .habitat-savane {
            background: #fef5e7;
            color: #7d6608;
            border: 1px solid #f9e79f;
        }

        .habitat-jungle {
            background: #eafaf1;
            color: #186a3b;
            border: 1px solid #a9dfbf;
        }

        .habitat-desert {
            background: #fdecea;
            color: #943126;
            border: 1px solid #f5b7b1;
        }

        .habitat-ocean {
            background: #ebf5fb;
            color: #1b4f72;
            border: 1px solid #aed6f1;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 25px 30px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.8em;
            color: #2d3748;
            font-weight: 700;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 2em;
            color: #718096;
            cursor: pointer;
            padding: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: #f7fafc;
            color: #2d3748;
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
            font-size: 1em;
        }

        .form-label .required {
            color: #e53e3e;
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            color: #4a5568;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            color: #4a5568;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .form-select:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        .file-upload {
            display: block;
            width: 100%;
            padding: 12px 15px;
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f7fafc;
        }

        .file-upload:hover {
            border-color: #4299e1;
            background: #ebf8ff;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload-text {
            color: #718096;
            font-size: 0.95em;
        }

        .file-upload-icon {
            font-size: 2em;
            margin-bottom: 10px;
            color: #4299e1;
        }

        .image-preview {
            margin-top: 15px;
            text-align: center;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .emoji-picker {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .emoji-option {
            font-size: 2em;
            padding: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .emoji-option:hover {
            border-color: #4299e1;
            background: #ebf8ff;
            transform: scale(1.1);
        }

        .emoji-option.selected {
            border-color: #4299e1;
            background: #ebf8ff;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-cancel {
            padding: 10px 25px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #4a5568;
            font-weight: 600;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
        }

        .btn-submit {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            background: #48bb78;
            color: white;
            font-weight: 600;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #38a169;
        }
    </style>
</head>

<body>
    <div class="modal" id="addAnimalModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">🦁 Ajouter un Animal</h2>
                <button class="modal-close" onclick="closeModal(modal)">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addAnimalForm" action="ajout.php" method="post">
                    <div class="form-group">
                        <label class="form-label">
                            Nom de l'animal <span class="required">*</span>
                        </label>
                        <input type="text" name="animal_name" class="input form-input" placeholder="Ex: Lion, Éléphant..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            image de l'animal <span class="required">*</span>
                        </label>
                        <input type="text" name="image" class="input form-input" placeholder="Ex: https://..." required>
                    </div>



                    <div class="form-group">
                        <label class="form-label">
                            Habitat <span class="required">*</span>
                        </label>
                        <select class="form-select input" name="habitat" required>
                            <option value="">Sélectionner un habitat</option>
                            <option value="1">🌾 Savane</option>
                            <option value="2">🌴 Jungle</option>
                            <option value="4">🏜️ Désert</option>
                            <option value="3">🌊 Océan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Type Alimentaire <span class="required">*</span>
                        </label>
                        <select class="form-select input" name="type" required>
                            <option value="">Sélectionner un type</option>
                            <option value="🥩 Carnivore">🥩 Carnivore</option>
                            <option value="🌿 Herbivore">🌿 Herbivore</option>
                            <option value="🍽️ Omnivore">🍽️ Omnivore</option>
                        </select>
                    </div>



                    <div class="form-group">
                        <label class="form-label">
                            Description (optionnel)
                        </label>
                        <textarea class="input form-input" rows="4" name="description" placeholder="Ajouter une description de l'animal..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal(modal)">Annuler</button>
                        <button type="submit" name="add" class="btn-submit" onclick="operation()">✓ Ajouter l'Animal</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div class="modal" id="modifAnimalModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">🦁 Ajouter un Animal</h2>
                <button class="modal-close" onclick="closeModal(modalmod)">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addAnimalForm" action="modifier.php" method="post">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="form-label">
                            Nom de l'animal
                        </label>
                        <input type="text" name="animal_name" class="input form-input" placeholder="Ex: Lion, Éléphant...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            image de l'animal
                        </label>
                        <input type="text" name="image" class="input form-input" placeholder="Ex: https://...">
                    </div>



                    <div class="form-group">
                        <label class="form-label">
                            Habitat
                        </label>
                        <select class="form-select input" name="habitat">
                            <option value="">Sélectionner un habitat</option>
                            <option value="1">🌾 Savane</option>
                            <option value="2">🌴 Jungle</option>
                            <option value="4">🏜️ Désert</option>
                            <option value="3">🌊 Océan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Type Alimentaire
                        </label>
                        <select class="form-select input" name="type">
                            <option value="">Sélectionner un type</option>
                            <option value="🥩 Carnivore">🥩 Carnivore</option>
                            <option value="🌿 Herbivore">🌿 Herbivore</option>
                            <option value="🍽️ Omnivore">🍽️ Omnivore</option>
                        </select>
                    </div>



                    <div class="form-group">
                        <label class="form-label">
                            Description (optionnel)
                        </label>
                        <textarea class="input form-input" rows="4" name="description" placeholder="Ajouter une description de l'animal..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal(modalmod)">Annuler</button>
                        <button type="submit" name="modifier" class="btn-submit" onclick="operation()">✓ Modifier l'Animal</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="container">
        <header>
            <h1>🦁 Zoo Animals 🐼</h1>
            <p class="subtitle">Apprendre et s'amuser avec les animaux du zoo!</p>
        </header>

        <div class="filters">
            <div class="filter-group">
                <span class="filter-label">🔍 Filtrer par:</span>
                <form action="index.php" method="post" id="filterForm">
                    <select name="filterHabitat" id="filterHabitat">
                        <option value="">Tous les habitats</option>
                        <option value="1" name="Savane">Savane</option>
                        <option value="2" name="Jungle">Jungle</option>
                        <option value="4" name="Désert">Désert</option>

                        <option value="3" name="Océan">Océan</option>
                    </select>
                    <select name="filterType">
                        <option value="">Tous les types</option>
                        <option value="🥩 Carnivore">Carnivore</option>
                        <option value="🌿 Herbivore">Herbivore</option>
                        <option value="🍽️ Omnivore">Omnivore</option>
                    </select>
                    <button class="btn" name="filter">Filtrer</button>
                </form>
                <form action="index.php" method="post">
                    <input type="text" name="search" placeholder="Rechercher un animal...">
                    <button name="search-btn" class="btn">Rechercher</button>
                </form>
                <button class="btn btn-add" onclick="openModal(modal)">➕ Ajouter un animal</button>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($total) ?></div>
                <div class="stat-label">🦁 Total Animaux</div>

            </div>



            <div class="stat-card">
                <div class="stat-number"><?= count($dataCtrOm) ?></div>
                <div class="stat-label">🍽️ Omnivore</div>
                <div class="range">
                    <div style="width : <?= $omnivore . '%' ?>" class="valueOmn"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($dataCtrCar) ?></div>
                <div class="stat-label">🥩 Carnivores</div>
                <div class="range">
                    <div style="width : <?= $carnivore . '%' ?>" class="valueCar"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($dataCtrHerb) ?></div>
                <div class="stat-label">🌿 Herbivores</div>
                <div class="range">
                    <div style="width : <?= $herbivore . '%' ?>" class="valueHerb"></div>
                </div>
            </div>
        </div>


        <div class='animals-grid'>
            <?php
            // print_r($data);
            if (empty($dataAffichage)) {

                echo '<div class="no-animals">
                        🚫 Aucun animal trouvé pour cette recherche.
                    </div>';
            } else {
                foreach ($dataAffichage as $value) {
                    echo "<div class='animal-card'>
            <div class='animal-image'>
                <img class='animal-image' src='" . $value["image"] . "' alt='" . $value["nom"] . "'>
            </div>
            <div class='animal-info'>
                <div class='animal-name'>" . $value["nom"] . "</div>
                <div class='animal-detail'><strong>Habitat:</strong> <span class='habitat-tag habitat-savane'>" . $value["nom_habitat"] . "</span></div>
                <div class='animal-detail'><strong>Type:</strong> " . $value["type_alimentaire"] . "</div>
                <div class='animal-actions'>
                    <button class='btn-small btn-edit' onclick='modifier({$value['animal_id']}, {$value['nom']}), {$value['animal_id']}, {$value['type_alimentaire']}, {$value['image']}, {$value['habitat_id']}'>✏️ Modifier</button>
                    <form action='delete.php' method='post'><button type='submit' name='delete' class='btn-small btn-delete' value='{$value['animal_id']}'>Supprimer</button></form>
                </div>
            </div>
        </div>";
                }
            }
            ?>


        </div>
    </div>

    <script>
        let modal = document.getElementById('addAnimalModal')
        let modalmod = document.getElementById('modifAnimalModal')

        function openModal(para) {
            para.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        let imgs = document.querySelectorAll('img');
        imgs.forEach(e => {
            console.log(e);
        })

        function closeModal(para) {
            para.classList.remove('active');
            document.body.style.overflow = 'scroll';
        }

        function modifier(id, nom, type, image, habitat, description) {

            modalmod.querySelector("input[name='id']").value = id;
            modalmod.querySelector("input[name='animal_name']").value = nom;
            modalmod.querySelector("input[name='image']").value = image;
            modalmod.querySelector("select[name='type']").value = type;
            modalmod.querySelector("select[name='habitat']").value = habitat;
            modalmod.querySelector("textarea[name='description']").value = description;

            modalmod.classList.add("active");
        }
    </script>
</body>

</html>