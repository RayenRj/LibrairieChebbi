<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="client.css">

</head>
<body>
    <form action="" class="addPackContainer">
        <div class="popUpContainer">
            <div class="overlay"></div>
            <div class="popUpCard">
                <div class="popUpHead">
                    <h2>📦 Ajouer un Pack</h2>
                    <div>
                        <i class="fa-solid fa-x"></i>
                    </div>
                </div>
                <fieldset>
                <div class="triple">
                    <div>
                        <label>Libellé <span class="red">*</span></label>
                        <div>
                            <input type="text" name="libelle" id="" placeholder="Entrer le libellé de l'article" required>
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>
                    <div>
                        <label>Prix Unitaire <span class="red">*</span></label>
                        <div class="prixContainer">
                            <input type="text" name="prix" id="" placeholder="Entrer le prix" required>
                            <i class="fa-solid fa-dollar-sign"></i>
                            <span>DT</span>
                        </div>
                    </div>
                    <div>
                        <label>Quantité en stock <span class="red">*</span></label>
                        <div>
                            <input type="text" name="libelle" id="" placeholder="Entrer la quantité" required> 
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>

                </div>


                <div class="triple">
                    <div>
                        <label>Remise (%)</label>
                        <div class="prixContainer">
                            <input type="number" name="remise" id="" placeholder="Entrer la remise en pourcentage">
                            <i class="fa-solid fa-percent"></i>
                            <span>DT</span>
                        </div>
                    </div>
                    <div>
                        <label>Categorie <span class="red">*</span></label>
                        <div>
                            <select id="categorie" name="categorie">
                                <option value="">-- Sélectionnez une le type --</option>
                                <option value="ecriture">Écriture</option>
                                <option value="papeterie">Papeterie</option>
                                <option value="classement">Classement</option>
                                <option value="geometrie">Géométrie</option>
                                <option value="coupe_collage">Coupe et collage</option>
                                <option value="dessin_arts">Dessin et arts</option>
                                <option value="sacs_accessoires">Sacs et accessoires</option>
                                <option value="calcul_sciences">Calcul et sciences</option>
                                <option value="numerique">Numérique</option>
                                <option value="livres_pedagogiques">Livres pédagogiques</option>
                                <option value="fournitures_bureau">Fournitures de bureau</option>
                                <option value="others">Others</option>
                            </select>
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                    </div>

                </div>

                <div class="double">
                    <div class="single description">
                        <label for="">Description</label>
                        <div>
                            <textarea name="description" id="" placeholder="Entrez la description de l'article"></textarea>
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                    </div>
                    <div class="single">
                            <label for="">Image de l'article <span class="red">*</span></label>
                            <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            </div>
                            <div class="text">
                                <span>Click to upload image</span>
                            </div>
                            <input type="file" id="file">
                        </label>

                    </div>
                </div>
                </fieldset>

                <fieldset>
                    <div class="heading">
                        <h3>Ajouter des articles </h3>
                        <div>
                            <div class="search">
                                <input type="text" name="" id="" placeholder="Rechercher un article...">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <select id="critereRecherche" name="critereRecherche">
                                <option value="">Critére de Recherche </option>
                                <option value="libelle">libellé</option>
                                <option value="categorie">catégorie</option>
                                <option value="marque">marque</option>
                                <option value="prixUnitaire">prix unitaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="tableContainer">
                        
                        <table id="addPackTable">
                            <thead>
                                <th>Article</th>
                                <th>Catégorie</th>
                                <th>Marque</th>
                                <th>Prix Unitaire</th>
                                <th>Stock</th>
                                <th>Quantité a ajouter</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button>Confirmé</button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button>Confirmé</button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button>Confirmé</button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button>Confirmé</button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button>Confirmé</button></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button>Confirmé</button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="bottom">
                        <div class="pagination">
                            <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                            <a href="#" class="pagination-selected">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#">4</a>
                            <a href="#">5</a>
                            <a href="#" id="three-dots">...</a>
                            <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>

                    <div class="articleSelectionne">
                        <div class="heading">
                            <h3>Les Articles Selectionnées</h3>
                        </div>
                        <div class="tableContainer">
                            
                            <table id="addPackTable">
                                <thead>
                                    <th>Article</th>
                                    <th>Catégorie</th>
                                    <th>Marque</th>
                                    <th>Prix Unitaire</th>
                                    <th>Stock</th>
                                    <th>Quantité</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                            <div class="text">
                                                <h4>Cahier 96 pages</h4>
                                                <p>Cah_96</p>
                                            </div>
                                        </td>
                                        <td>papeterie</td>
                                        <td>Kimia </td>
                                        <td>1,250 DT</td>
                                        <td>450</td>
                                        <td>5</td>
                                        <td><button>Supprimée</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                            <div class="text">
                                                <h4>Cahier 96 pages</h4>
                                                <p>Cah_96</p>
                                            </div>
                                        </td>
                                        <td>papeterie</td>
                                        <td>Kimia </td>
                                        <td>1,250 DT</td>
                                        <td>450</td>
                                        <td>5</td>
                                        <td><button>Supprimée</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                            <div class="text">
                                                <h4>Cahier 96 pages</h4>
                                                <p>Cah_96</p>
                                            </div>
                                        </td>
                                        <td>papeterie</td>
                                        <td>Kimia </td>
                                        <td>1,250 DT</td>
                                        <td>450</td>
                                        <td>5</td>
                                        <td><button>Supprimée</button></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <div class="last">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Ajouter Pack">
                </div>
            </div>
        </div>
    </form>


</body>
</html>