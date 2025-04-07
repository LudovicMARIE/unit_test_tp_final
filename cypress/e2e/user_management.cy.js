describe('Test E2E de la gestion des utilisateurs', () => {
  it("Ajout, modification et suppression d'un utilisateur", () => {
      cy.visit('/src/index.html');
      cy.get('#name').type('test');
      cy.get('#email').type('test@test.test');
      cy.get("button[type='submit']").click();
      cy.contains('test (test@test.test)').should('be.visible');
      cy.contains('test (test@test.test)')
          .parent()
          .find('button')
          .contains('✏️')
          .click();
      cy.get('#name').clear().type('test2');
      cy.get('#email').clear().type('test2@test.test');
      cy.get("button[type='submit']").click();
      cy.contains('test2 (test2@test.test)').should('be.visible');
      cy.contains('test2 (test2@test.test)')
          .parent()
          .find('button')
          .contains('❌')
          .click();
      cy.contains('test2 (test2@test.test)').should('not.exist');
  });
});