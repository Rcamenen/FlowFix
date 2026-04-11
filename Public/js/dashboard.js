const teamId = document.getElementById('team-dashboard').dataset.teamId;
let frictionsLoaded = false;

// Gestion des onglets
document.querySelectorAll('.tab-btn').forEach(btn => {

    btn.addEventListener('click', () => {
        
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab).classList.add('active');

        // Chargement lazy au premier clic sur "liste"
        if (btn.dataset.tab === 'frictions' && !frictionsLoaded) {
            loadFrictions(teamId, 1);
            frictionsLoaded = true;
        }
    });
});

// Chargement AJAX de la liste paginée
function loadFrictions(teamId, page) {
    fetch(`/team/${teamId}/frictions?page=${page}`)
        .then(r => r.text())
        .then(html => {
            document.getElementById('frictions-container').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('frictions-container').innerHTML = '<p>Erreur de chargement.</p>';
        });
}