<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppings</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="../assets/css/panier.css">
</head>
<body>
    <?php include "../includes/header.html" ?>

    <aside>
        <div>
            <h1>Shopping <span>Cart</span></h1>

            <!-- From Uiverse.io by alexmaracinaru --> 
            <button class="cta">
                <svg width="15px" height="10px" viewBox="0 0 13 10">
                    <path d="M1,5 L11,5"></path>
                    <polyline points="5 1 1 5 5 9"></polyline>
                </svg>
                <span> Go back to shopping</span>
            </button>

        </div>
        <hr>
    </aside>

    <!-- partie ken mafamech des articles -->
    <!--
    <main class="no-article">
        <div class="empty-cart">
            <div class="icon">🛒</div>
            <h2>Your cart is empty</h2>
            <p>Add some Shool supplies to get Started!</p>

            
            <button class="cursor-pointer transition-all bg-blue-500 text-white px-6 py-2 rounded-lg
            border-blue-600
            border-b-[4px] hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[6px]
            active:border-b-[2px] active:brightness-90 active:translate-y-[2px]">
            Shop Now
            </button>
        </div>
    </main>
    -->

    <!-- partie famma article -->


    <main class="article-existe">
        <section>
            <div class="article">
                <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Prix total</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <form action="">
                <tbody>
                    <tr>
                        <td>
                            <img class="img" height="100%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeS3q_huspsyYhjSywSAX6YM38s7q89QSwug&s" alt="">
                        </td>
                        <td>
                            <div class="description">
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. qdqsdqssdqsdqzaez</p>
                            </div>
                        </td>
                        <td class="td-quantite">
                            <button>-</button>
                            <input type="number" id="quantite" value="0">
                            <button>+</button>
                        </td>
                        <td>
                            <span class="prix-unitaire">1550dt</span>
                        </td>
                        <td>
                            <span class="prix-totale">1,750dt</span>
                        </td>

                        <td>
                            <button class="delete">X</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="img" height="100%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeS3q_huspsyYhjSywSAX6YM38s7q89QSwug&s" alt="">
                        </td>
                        <td>
                            <div class="description">
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. qdqsdqssdqsdqzaez</p>
                            </div>
                        </td>
                        <td class="td-quantite">
                            <button>-</button>
                            <input type="number" value="0" id="quantite">
                            <button>+</button>
                        </td>
                        <td>
                            <span class="prix-unitaire">1550dt</span>
                        </td>
                        <td>
                            <span class="prix-totale">1,750dt</span>
                        </td>

                        <td>
                            <button class="delete">X</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="img" height="100%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeS3q_huspsyYhjSywSAX6YM38s7q89QSwug&s" alt="">
                        </td>
                        <td>
                            <div class="description">
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. qdqsdqssdqsdqzaez</p>
                            </div>
                        </td>
                        <td class="td-quantite">
                            <button>-</button>
                            <input type="number" id="quantite" value="0">
                            <button>+</button>
                        </td>
                        <td>
                            <span class="prix-unitaire">1550dt</span>
                        </td>
                        <td>
                            <span class="prix-totale">1,750dt</span>
                        </td>

                        <td>
                            <button class="delete">X</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="img" height="100%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeS3q_huspsyYhjSywSAX6YM38s7q89QSwug&s" alt="">
                        </td>
                        <td>
                            <div class="description">
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. qdqsdqssdqsdqzaez</p>
                            </div>
                        </td>
                        <td class="td-quantite">
                            <button>-</button>
                            <input type="number" id="quantite" value="0">
                            <button>+</button>
                        </td>
                        <td>
                            <span class="prix-unitaire">1550dt</span>
                        </td>
                        <td>
                            <span class="prix-totale">1,750dt</span>
                        </td>

                        <td>
                            <button class="delete">X</button>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="4"  class="total-payer">Total a payer</td>
                        <td>1,750dt</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="3">
                            <div class="button">
                        <!-- From Uiverse.io by carlosepcc --> 
                                <button class="cursor-pointer transition-all bg-blue-500 text-white px-6 py-2 rounded-lg
                                border-blue-600
                                border-b-[4px] hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[6px]
                                active:border-b-[2px] active:brightness-90 active:translate-y-[2px] button-commande">
                                passer la commande >>
                                </button>
                        </div>
                        </td>
                    </tr>

                </tbody>
                </table>


                </form>



            </div>
        </section>
    </main>
</body>
</html>