<script src="/js/balance.js"></script>

<div class="hr"></div>

<h3>Etiquettes</h3>

<!-- Sélection de la balance -->
<div class="container mt-3">
    <label for="selectBalance">Choisir une Balance :</label>
    <select id="selectBalance" class="form-control">
        <option value="">-- Sélectionner une balance --</option>
        <?php foreach ($balances as $balance): ?>
            <option value="<?= h($balance['Balance']['id']); ?>" 
                    data-ip="<?= h($balance['Balance']['adresse_ip']); ?>" 
                    data-port="<?= h($balance['Balance']['port']); ?>">
                <?= h($balance['Balance']['libelle']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Indicateur de statut de la balance -->
<div class="container mt-3">
    <span id="balanceStatus" class="badge bg-secondary">Aucune balance sélectionnée</span>
</div>

<!-- Boutons de contrôle du scan -->
<div class="container mt-3">
    <button id="startScan" class="btn btn-primary" style="display: none;">Démarrer le Scan</button>
    <button id="stopScan" class="btn btn-danger" style="display: none;">Arrêter le Scan</button>
</div>

<!-- Formulaire pour stocker les poids -->
<div class="container mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Poids (kg)</th>
                <th>Action</th>
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
    let intervalId = null;

    document.getElementById("selectBalance").addEventListener("change", function() {
        let balanceId = this.value;
        if (!balanceId) {
            document.getElementById("balanceStatus").textContent = "Aucune balance sélectionnée";
            document.getElementById("balanceStatus").className = "badge bg-secondary";
            document.getElementById("startScan").style.display = "none";
            document.getElementById("stopScan").style.display = "none";
            return;
        }

        verifierBalance(balanceId);
    });

    function verifierBalance(balanceId) {
        fetch(`/jcollab/jcollab_eng/productions/checkBalanceAvailability/${balanceId}`)
            .then(response => response.json())
            .then(data => {
                let badge = document.getElementById("balanceStatus");
                let startScanBtn = document.getElementById("startScan");

                if (data.statut === "disponible") {
                    badge.classList.remove("bg-secondary", "bg-danger");
                    badge.classList.add("bg-success");
                    badge.textContent = "Balance disponible ✅";
                    startScanBtn.style.display = "block";
                } else {
                    badge.classList.remove("bg-secondary", "bg-success");
                    badge.classList.add("bg-danger");
                    badge.textContent = "Balance indisponible ❌";
                    startScanBtn.style.display = "none";
                }
            })
            .catch(error => {
                console.error("Erreur AJAX :", error);
                let badge = document.getElementById("balanceStatus");
                badge.classList.remove("bg-secondary", "bg-success");
                badge.classList.add("bg-danger");
                badge.textContent = "Erreur de connexion ❌";
                document.getElementById("startScan").style.display = "none";
            });
    }

    document.getElementById("startScan").addEventListener("click", function() {
        let balanceId = document.getElementById("selectBalance").value;
        if (!balanceId) {
            alert("Veuillez sélectionner une balance.");
            return;
        }

        document.getElementById("stopScan").style.display = "block";
        document.getElementById("startScan").style.display = "none";

        if (intervalId) {
            clearInterval(intervalId);
        }

        intervalId = setInterval(() => {
            fetch(`/jcollab/jcollab_eng/productions/getPoidsBalance/${balanceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.poids && data.poids !== lastPoids) {
                        lastPoids = data.poids;
                        let poidsFormate = parseFloat(data.poids).toFixed(3);

                        ajouterLignePoids(poidsFormate);
                        enregistrerEtImprimer(productionId, poidsFormate);
                    }
                })
                .catch(error => console.error("Erreur AJAX :", error));
        }, 3000);
    });

    document.getElementById("stopScan").addEventListener("click", function() {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }

        document.getElementById("stopScan").style.display = "none";
        document.getElementById("startScan").style.display = "block";
    });

    window.enregistrerEtImprimer = function(productionId, poids) {
        fetch(`/jcollab/jcollab_eng/productions/etiquettes/${productionId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: "poids=" + encodeURIComponent(poids)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("⛔ Erreur :", data.error);
            }
            if (data.message) {
                console.log("✔ Succès :", data.message);
            }
        })
        .catch(error => console.error("Erreur AJAX :", error));
    }

    window.supprimerPoids = function(element, poids) {
        console.log("📡 Suppression du poids :", poids);

        fetch("/jcollab/jcollab_eng/productions/deletePoids", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: "poids=" + encodeURIComponent(poids)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("⛔ Erreur :", data.error);
            }
            if (data.message) {
                console.log("✔ Poids supprimé avec succès.");
                let row = element.closest("tr");
                row.remove();
            }
        })
        .catch(error => console.error("Erreur AJAX :", error));
    }

    function ajouterLignePoids(poids) {
        let poidsList = document.getElementById("poidsList");
        let newRow = document.createElement("tr");

        newRow.innerHTML = `
            <td>${compteur}</td>
            <td><input type="text" class="form-control" value="${poids}" readonly></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="enregistrerEtImprimer('${productionId}', '${poids}')">🖨 Imprimer</button>
                <button class="btn btn-danger btn-sm" onclick="supprimerPoids(this, '${poids}')">🗑 Supprimer</button>
            </td>
        `;

        poidsList.prepend(newRow);
        compteur++;
    }
});
</script>
