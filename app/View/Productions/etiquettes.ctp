<script src="/js/balance.js"></script>

<div class="hr"></div>

<h3>Etiquettes</h3>

<!-- Formulaire pour stocker les poids -->
<div class="container mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Poids (kg)</th>
            </tr>
        </thead>
        <tbody id="poidsList">
            <!-- Les valeurs s'ajoutent ici -->
        </tbody>
    </table>
</div>

<!-- Champ caché pour le Production ID -->
<input type="hidden" id="production_id" value="<?= h($production_id); ?>">

<script>
document.addEventListener("DOMContentLoaded", function() {
    let lastPoids = null;
    let compteur = 1;
    let productionId = document.getElementById("production_id").value;

    setInterval(() => {
        fetch("/jcollab/jcollab_eng/productions/getPoidsBalance")
            .then(response => response.json())
            .then(data => {
                if (data.poids && data.poids !== lastPoids) {
                    lastPoids = data.poids;
                    let poidsFormate = parseFloat(data.poids).toFixed(3); // 🔹 FORCER 3 DÉCIMALES

                    // Ajouter une nouvelle ligne dans le tableau
                    let poidsList = document.getElementById("poidsList");
                    let newRow = document.createElement("tr");

                    newRow.innerHTML = `
                        <td>${compteur}</td>
                        <td><input type="text" class="form-control" value="${poidsFormate}" readonly></td>
                    `;

                    poidsList.prepend(newRow);
                    compteur++;

                    // 🔹 Enregistrer et imprimer
                    enregistrerEtImprimer(productionId, poidsFormate);
                }
            })
            .catch(error => console.error("Erreur AJAX :", error));
    }, 3000);
});

function enregistrerEtImprimer(productionId, poids) {
    console.log("📡 Envoi de la requête AJAX pour imprimer et enregistrer !");
    console.log("Production ID :", productionId);
    console.log("Poids :", poids);

    fetch("/jcollab/jcollab_eng/productions/etiquettes/" + productionId, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: "poids=" + encodeURIComponent(poids) // 🔹 ENVOI COMME TEXTE POUR GARDER 3 DÉCIMALES
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ Réponse du serveur :", data);

        if (data.error) {
            console.error("⛔ Erreur :", data.error);
        }
        if (data.message) {
            console.log("✔ Succès :", data.message);
        }
    })
    .catch(error => console.error("Erreur AJAX :", error));
}
</script>
