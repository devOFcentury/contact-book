<?php
require './contact.class.php';
$contact_instance = new Contact();
$contacts = $contact_instance->get_contacts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Contact Book</title>
     <link rel="stylesheet" href="style.css">
</head>

<body>
     <!-- modal d'ajout de contact -->
     <div id="modal-create">
          <div class="modal-create__modal-content">
               <span class="close-modal-create">&times;</span>
               <p>Nouveau Contact</p>
               <form class="form">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" class="input">

                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="input">

                    <label>categorie</label>
                    <select id="categorie" name="categorie" class="select">
                         <option value="normal">normal</option>
                         <option value="important">important</option>
                         <option value="blocked">blocked</option>
                    </select>

                    <button type="submit" id="create" name="action" value="create">Submit</button>
               </form>
          </div>
     </div>

     <!-- modal vue sur contact -->
     <div id="modal-view">
          <div class="modal-view__modal-content">
               <span class="close-modal-view">&times;</span>
               <p>View Modal</p>
          </div>
     </div>

     <!-- modal d'édition de contact -->
     <div id="modal-edit">
          <div class="modal-edit__modal-content">
               <span class="close-modal-edit">&times;</span>
               <p>Edit Modal</p>
          </div>
     </div>


     <div class="container">
          <h2>Ma Liste de contact</h2>
          <button class="add-contact-modal">Ajouter</button>
          <div style="overflow-x: auto;">
               <table>
                    <thead>
                         <tr>
                              <th>Nom</th>
                              <th>Prénom</th>
                              <th>Categories</th>
                         </tr>
                    </thead>
                    <tbody id="result"></tbody>
               </table>
          </div>
     </div>
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script>
          $(function() {
               function getAllContact() {
                    $.ajax({
                         url: 'ajax.php',
                         type: 'POST',
                         data: {
                              action: 'fetch_contacts'
                         },
                         success: function(response) {
                              var res = $.parseJSON(response);
                              $('#result').html(res.data);
                         }
                    });
               }

               getAllContact();

               // toggle create modal
               $('.add-contact-modal').on('click', function() {
                    $('#modal-create').show('slow');
                    $('.close-modal-create').on('click', function() {
                         $('#modal-create').hide('slow');
                    });
               });

               // add new contact
               $('#create').on('click', function(e) {
                    e.preventDefault();
                    var nom = $('#nom').val();
                    var prenom = $('#prenom').val();
                    var categorie = $('#categorie').val();
                    var create = $('#create').val();
                    if (nom != '' && prenom != '' && categorie != '') {
                         $.ajax({
                              type: 'POST',
                              url: 'ajax.php',
                              data: {nom,prenom,categorie,action: create},
                              success: function(response) {
                                   $('#modal-create').hide('slow');
                                   $('.form')[0].reset();
                                   getAllContact();
                              }
                         });
                    } else {
                         $('.form').prepend("<span class='error-form'>Veuillez remplir les champs vides!</span>");
                    }
               });

          });

          // toggle view modal
          $(document).on('click', '.look-contact-modal', function() {
               $('#modal-view').show('slow');
               $('.close-modal-view').on('click', function() {
                    $('#modal-view').hide('slow');
               });
          });

          //add new contact
          // $(document).on('submit', '#create', function (e) {
          //      e.preventDefault();

          //      var nom = $('#nom').val();
          //      var prenom = $('#prenom').val();
          //      var categorie = $('#categorie').val();
          //      var create = $('#create').val();
          //      if (nom != '' && prenom != '' && categorie != '') {
          //           $.ajax({
          //                type: 'POST',
          //                url: 'code.php',
          //                data: {nom, prenom, categorie, action},
          //                success: function (response) {
          //                     var res = $.parseJSON(response);
          //                     if (res.status == 422) {
          //                          $('#errorMessage').removeClass('d-none');
          //                          $('#errorMessage').text(res.message);
          //                     }
          //                     else if(res.status == 200) {
          //                          $('#errorMessage').addClass('d-none');
          //                          $('#studentAddModal').modal('hide');
          //                          $('#saveStudent')[0].reset();
          //                          // rafraichir la table avec l'id #myTable sans recharger la page
          //                          $('#myTable').load(location.href + " #myTable");

          //                     }
          //                }
          //           });
          //      } else {
          //           $('.form').prepend = "<span class='error-form'></span>";
          //      }
          // })
     </script>
</body>

</html>