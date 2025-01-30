function getPoidsEtImprimer() {
    console.log("📡 Requête AJAX pour récupérer le poids...");

    fetch('/jcollab/jcollab_eng/productions/getPoidsBalance')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert("❌ Erreur : " + data.error);
                return;
            }

            let poids = data.poids;
            console.log("Poids brut reçu :", poids);

            // 🔹 Vérifier si le poids est un nombre valide
            if (isNaN(poids) || poids <= 0) {
                console.warn("⚠ Aucun poids détecté !");
                return;
            }

            // 🔹 Forcer le poids à 3 décimales
            let poidsFormate = parseFloat(poids).toFixed(3);
            console.log("✅ Poids formaté (3 décimales) :", poidsFormate);

            // 🔹 Envoyer à l'impression et à la sauvegarde
            enregistrerEtImprimer(poidsFormate);
        })
        .catch(error => console.error("❌ Erreur AJAX :", error));
}




function imprimerPoids(poids) {
    // Envoi du poids à la méthode etiquettes()
    fetch(`/production/etiquettes/${poids}`)
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
            } else {
                alert("Erreur d'impression !");
            }
        })
        .catch(error => console.error("Erreur AJAX :", error));
}

// Ajouter un bouton pour récupérer le poids et imprimer
document.addEventListener("DOMContentLoaded", function() {
    let btn = document.createElement("button");
    btn.innerText = "Lire Poids et Imprimer";
    btn.onclick = getPoidsEtImprimer;
    document.body.appendChild(btn);
});
