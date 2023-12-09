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
     <header>
          <h2>Liste de contact</h2>
     </header>
     <!-- modal d'ajout de contact -->
     <div id="modal-create">
          <div class="modal-create__modal-content">
               <span class="close-modal-create">&times;</span>
               <p class="modal-title">Nouveau Contact</p>
               <form class="form">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" class="input">

                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="input">

                    <label for="numero">Numéro</label>
                    <input type="text" name="numero" id="numero" class="input">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="input">

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
               <p class="modal-title">Fiche</p>
               <div class="info">
                    <p>XXXXXXXXXXXX</p>
                    <p>XXXXXXXXXXXX</p>
                    <p>XXXXXXXXXXXX</p>
                    <p>XXXXXXXXXXXX</p>
                    <p>XXXXXXXXXXXX</p>
               </div>
               <button type="submit" id="edit" name="action" value="edit">Editer</button>
          </div>
     </div>

     <!-- modal d'édition de contact -->
     <div id="modal-edit">
          <div class="modal-edit__modal-content">
               <span class="close-modal-edit">&times;</span>
               <p class="modal-title">Editer Contact</p>
               <form class="form">
                    <label for="nom-edit">Nom</label>
                    <input type="text" name="nom-edit" id="nom-edit" class="input">

                    <label for="prenom-edit">Prénom</label>
                    <input type="text" name="prenom-edit" id="prenom-edit" class="input">

                    <label for="numero-edit">Numéro</label>
                    <input type="text" name="numero-edit" id="numero-edit" class="input">

                    <label for="email-edit">Email</label>
                    <input type="text" name="email-edit" id="email-edit" class="input">

                    <label>categorie</label>
                    <select id="categorie-edit" name="categorie-edit" class="select">
                         <option value="normal">normal</option>
                         <option value="important">important</option>
                         <option value="blocked">blocked</option>
                    </select>

                    <button type="submit" id="update" name="action" value="update">Mettre à jour</button>
               </form>
          </div>
     </div>


     <div class="container">
          <div class="filtre">
               <input id="search" type="text" placeholder="Search..">
               <button class="add-contact-modal">Ajouter un contact</button>
          </div>
          <div style="overflow-x: auto;">
               <table id="myTable">
                    <thead>
                         <tr>
                              <th>Nom</th>
                              <th>Prénom</th>
                              <th>Numéro</th>
                              <th>Email</th>
                              <th>Categories</th>
                         </tr>
                    </thead>
                    <tbody class="contact-table" id="result"></tbody>
               </table>
          </div>
     </div>
     <footer>
          <p>Projet Réalisé Par VICH 2023, Dakar-Sénégal</p>
     </footer>
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="https://unpkg.com/jquery-tablesortable"></script>

     <script>
          $(function() {
               $('table#myTable').tableSortable();

               function getAllContact() {
                    $('.error-msg').remove();
                    $.ajax({
                         url: 'ajax.php',
                         type: 'POST',
                         data: {
                              action: 'fetch_contacts'
                         },
                         success: function(response) {
                              var res = $.parseJSON(response);
                              if (res.status == 422) {
                                   var err = "<p class='error-msg'>" + res.message + "</p>";
                                   $($err).insertAfter(".filtre");
                              } else if (res.status == 200) {
                                   $('.error-msg').remove();
                                   $('#result').html(res.data);
                              }
                         }
                    });
               }

               getAllContact();

               // toggle create modal
               $('.add-contact-modal').on('click', function() {
                    $('#modal-create').show('slow');
                    $('.close-modal-create').on('click', function() {
                         $('.form')[0].reset();
                         $('.error-form').remove();
                         $('#modal-create').hide('slow');
                    });
               });

               // add new contact
               $('#create').on('click', function(e) {
                    e.preventDefault();
                    $('.error-form').remove();
                    var nom = $('#nom').val();
                    var prenom = $('#prenom').val();
                    var numero = $('#numero').val();
                    var email = $('#email').val();
                    var categorie = $('#categorie').val();
                    var create = $('#create').val();
                    if (nom != '' && prenom != '' && email != '' && numero != '' && categorie != '') {
                         $.ajax({
                              type: 'POST',
                              url: 'ajax.php',
                              data: {
                                   nom,
                                   prenom,
                                   numero,
                                   email,
                                   categorie,
                                   action: create
                              },
                              success: function(response) {
                                   var res = $.parseJSON(response);
                                   if (res.status == 422) {
                                        var err = "<span class='error-form'>" + res.message + "</span>";
                                        $('.form').prepend(err);
                                   } else if (res.status = 200) {
                                        $('.form')[0].reset();
                                        $('.error-form').remove();
                                        $('#modal-create').hide('slow');
                                        getAllContact();
                                   }
                              }
                         });
                    } else {
                         $('.form').prepend("<span class='error-form'>Veuillez remplir les champs vides!</span>");
                    }
               });

               $("#search").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".contact-table tr").filter(function() {
                         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
               });

          });
          

          // toggle view modal
          $(document).on('click', '.see-contact-modal', function() {
               $('#modal-view').show('slow');
               $('.close-modal-view').on('click', function() {
                    $('#modal-view').hide('slow');
               });
               var contact_id = $(this).attr('key');
               $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: {
                         id: contact_id,
                         action: 'see'
                    },
                    success: function(response) {
                         var res = $.parseJSON(response);
                         if (res.status == 422) {
                              var err = "<p class='error-msg'>" + res.message + "</p>";
                              $($err).insertAfter(".filtre");
                              $('#modal-view').hide('slow');
                         } else if (res.status == 200) {
                              $('.info p:first').text(res.data.prenom);
                              $('.info p:eq(1)').text(res.data.nom);
                              $('.info p:eq(2)').text(res.data.numero);
                              $('.info p:eq(3)').text(res.data.email);
                              $('.info p:last').text(res.data.categorie);
                              $('#edit').attr('key', res.data.id);
                         }
                    }
               });

          });

          // toggle edit modal
          $(document).on('click', '#edit', function() {
               $('#modal-view').hide();
               $('#modal-edit').show('slow');
               $('.close-modal-edit').on('click', function() {
                    $('#modal-edit').hide('slow');
               });
               var contact_id = $(this).attr('key');
               $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: {
                         id: contact_id,
                         action: 'edit'
                    },
                    success: function(response) {
                         var res = $.parseJSON(response);
                         if (res.status == 422) {
                              var err = "<p class='error-msg'>" + res.message + "</p>";
                              $($err).insertAfter(".filtre");
                              $('#modal-edit').hide('slow');
                         } else if (res.status == 200) {
                              $('#nom-edit').val(res.data.nom);
                              $('#prenom-edit').val(res.data.prenom);
                              $('#numero-edit').val(res.data.numero);
                              $('#email-edit').val(res.data.email);
                              $('#categorie-edit').val(res.data.categorie);
                              $('#update').attr('key', res.data.id);
                         }
                    }
               });

          });

          // update contact
          $(document).on('click', '#update', function(e) {
               e.preventDefault();
               $('.error-form').remove();
               var nom = $('#nom-edit').val();
               var prenom = $('#prenom-edit').val();
               var numero = $('#numero-edit').val();
               var email = $('#email-edit').val();
               var categorie = $('#categorie-edit').val();
               var id = $('#update').attr('key');
               var update = $('#update').val();
               if (nom != '' && prenom != '' && categorie != '') {
                    $.ajax({
                         type: 'POST',
                         url: 'ajax.php',
                         data: {
                              nom_edit: nom,
                              prenom_edit: prenom,
                              numero_edit: numero,
                              email_edit: email,
                              categorie_edit: categorie,
                              id,
                              action: update
                         },
                         success: function(response) {
                              var res = $.parseJSON(response);
                              if (res.status == 422) {
                                   var err = "<span class='error-form'>" + res.message + "</span>";
                                   $('.form').prepend(err);
                              } else if (res.status == 200) {
                                   $('.form')[0].reset();
                                   $('.error-form').remove();
                                   $('#modal-edit').hide('slow');
                                   $.ajax({
                                        url: 'ajax.php',
                                        type: 'POST',
                                        data: {
                                             action: 'fetch_contacts'
                                        },
                                        success: function(response) {
                                             var res = $.parseJSON(response);
                                             if (res.status == 422) {
                                                  var err = "<p class='error-msg'>" + res.message + "</p>";
                                                  $($err).insertAfter(".filtre");
                                             } else if (res.status == 200) {
                                                  $('#result').html(res.data);
                                             }
                                        }
                                   });
                              }
                         }
                    });
               } else {
                    $('.form').prepend("<span class='error-form'>Veuillez remplir les champs vides!</span>");
               }
          });
     </script>
</body>

</html>