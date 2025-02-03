<script src="/js/balance.js"></script>

<div class="hr"></div>

<h3>Etiquettes</h3>

<!-- Sélection de la balance -->
<div class="container mt-3">
    <label for="selectBalance">Choisir une Balance :</label>
    <select id="selectBalance" class="form-control">
        <option value="">-- Sélectionner une balance --</option>
        <?php foreach ($balances as $balance): ?>
            <option value="<?= h($balance['Balance']['id']); ?>" data-ip="<?= h($balance['Balance']['adresse_ip']); ?>" data-port="<?= h($balance['Balance']['port']); ?>">
                <?= h($balance['Balance']['libelle']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Indicateur de statut de la balance -->
<div class="container mt-3">
    <span id="balanceStatus" class="badge bg-secondary">Aucune balance sélectionnée</span>
</div>

<!-- Bouton pour démarrer le scan (masqué par défaut) -->
<div class="container mt-3">
    <button id="startScan" class="btn btn-primary" style="display: none;">Démarrer le Scan</button>
</div>

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
    let intervalId = null;

    document.getElementById("selectBalance").addEventListener("change", function() {
        let balanceId = this.value;
        if (!balanceId) {
            document.getElementById("balanceStatus").textContent = "Aucune balance sélectionnée";
            document.getElementById("balanceStatus").className = "badge bg-secondary";
            document.getElementById("startScan").style.display = "none";
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

                        let poidsList = document.getElementById("poidsList");
                        let newRow = document.createElement("tr");

                        newRow.innerHTML = `
                            <td>${compteur}</td>
                            <td><input type="text" class="form-control" value="${poidsFormate}" readonly></td>
                        `;

                        poidsList.prepend(newRow);
                        compteur++;

                        enregistrerEtImprimer(productionId, poidsFormate);
                    }
                })
                .catch(error => console.error("Erreur AJAX :", error));
        }, 3000);
    });

    function enregistrerEtImprimer(productionId, poids) {
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
});
</script>
