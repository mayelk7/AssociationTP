const API = 'http://associationstp.test/api/v1';

// Tous les domaines
async function getDomaines() {
    const res = await fetch(`${API}/domaines`);
    return res.json();
}

// Toutes les associations (avec leur domaine)
async function getAssociations() {
    const res = await fetch(`${API}/associations`);
    return res.json();
}

// Détail d'une association
async function getAssociation(id) {
    const res = await fetch(`${API}/associations/${id}`);
    return res.json();
}

// Associations d'un domaine
async function getAssociationsByDomaine(domaineId) {
    const res = await fetch(`${API}/domaines/${domaineId}/associations`);
    return res.json();
}

// Tous les emails des associations
async function getEmails() {
    const res = await fetch(`${API}/emails`);
    return res.json();
}

// --- Exemple d'utilisation ---
(async () => {
    const domaines     = await getDomaines();
    const associations = await getAssociations();
    const emails       = await getEmails();
    console.log('Domaines :', domaines);
    console.log('Associations :', associations);
    console.log('Emails :', emails);
})();
