describe('Test d\'ajout d\'utilisateur', () => {
  it('Ajoute un utilisateur et vérifie sa présence dans la liste', () => {
    cy.viewport(784, 816);
    cy.visit('http://localhost/Tp2_test/src/gestion_produit/');

    cy.get('#name').click().type('Rayane');
    cy.get('#email').click().type('rayanebesrour4@gmail.com'); // Modification ici
    cy.get('#add-button').click();

    cy.get('#userList li').should('contain', 'Rayane (rayanebesrour4@gmail.com)'); // Modification ici
  });

  it('Modifie un utilisateur', () => {
    cy.contains('Rayane Besrour', { timeout: 5000 }).should('be.visible');
   
   // Sélectionner l'utilisateur dans la liste et cliquer sur son bouton Modifier
   cy.contains('li', 'Rayane Besrour')
   .should('exist')
   .within(() => {
     cy.get('button').first().click(); // Le premier bouton est Modifier (✏️)
   });
 
 // Modifier le champ nom et soumettre le formulaire
 cy.get('#name').clear().type('Rayane B.');
 cy.get('#userForm').submit(); // Soumettre le formulaire
 
 // Vérifier que le nom a bien été mis à jour
 cy.contains('Rayane B.').should('be.visible');
 cy.contains('Rayane Besrour').should('not.exist');
  });
 
});
