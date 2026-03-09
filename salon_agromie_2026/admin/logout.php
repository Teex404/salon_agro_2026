<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Générer un code conférence</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">

  <style>
    body{
      min-height: 100vh;
      margin: 0;
      color: #eef3f8;
      background:
        radial-gradient(circle at 12% 18%, rgba(0,209,255,0.10), transparent 24%),
        radial-gradient(circle at 88% 14%, rgba(212,175,55,0.09), transparent 22%),
        radial-gradient(circle at 82% 84%, rgba(0,168,107,0.11), transparent 24%),
        linear-gradient(135deg, #05080d 0%, #09111b 30%, #0c1522 65%, #04070b 100%);
      background-attachment: fixed;
      position: relative;
      overflow-x: hidden;
    }

    body::before{
      content: "";
      position: fixed;
      inset: 0;
      background:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
      background-size: 38px 38px;
      opacity: 0.22;
      pointer-events: none;
      z-index: 0;
      mask-image: radial-gradient(circle at center, black 55%, transparent 100%);
      -webkit-mask-image: radial-gradient(circle at center, black 55%, transparent 100%);
    }

    body::after{
      content: "";
      position: fixed;
      inset: 0;
      background:
        linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.025) 20%, transparent 40%),
        linear-gradient(300deg, transparent 0%, rgba(212,175,55,0.02) 18%, transparent 36%);
      pointer-events: none;
      z-index: 0;
    }

    .luxury-orb{
      position: fixed;
      border-radius: 50%;
      filter: blur(110px);
      pointer-events: none;
      z-index: 0;
      opacity: 0.95;
    }

    .luxury-orb.orb-cyan{
      width: 360px;
      height: 360px;
      top: 30px;
      left: 20px;
      background: rgba(0,209,255,0.12);
    }

    .luxury-orb.orb-gold{
      width: 300px;
      height: 300px;
      top: 90px;
      right: 70px;
      background: rgba(212,175,55,0.10);
    }

    .luxury-orb.orb-green{
      width: 340px;
      height: 340px;
      bottom: 10px;
      right: 80px;
      background: rgba(0,168,107,0.11);
    }

    .page-shell{
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 0;
      position: relative;
      z-index: 2;
    }

    .generator-card{
      width: 100%;
      max-width: 680px;
      position: relative;
      overflow: hidden;
      border-radius: 28px;
      background: linear-gradient(145deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03));
      border: 1px solid rgba(255,255,255,0.10);
      box-shadow:
        0 22px 60px rgba(0,0,0,0.45),
        inset 0 1px 0 rgba(255,255,255,0.08);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
    }

    .generator-card::before{
      content: "";
      position: absolute;
      top: -60px;
      right: -60px;
      width: 220px;
      height: 220px;
      background: radial-gradient(circle, rgba(0,209,255,0.18), transparent 65%);
      border-radius: 50%;
      pointer-events: none;
    }

    .generator-card::after{
      content: "";
      position: absolute;
      bottom: -80px;
      left: -80px;
      width: 240px;
      height: 240px;
      background: radial-gradient(circle, rgba(0,168,107,0.16), transparent 65%);
      border-radius: 50%;
      pointer-events: none;
    }

    .brand-chip{
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.08);
      color: var(--text-muted);
      font-size: 0.92rem;
      margin-bottom: 14px;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .page-subtitle{
      color: var(--text-muted);
      margin-bottom: 0;
    }

    .inner-panel{
      background: linear-gradient(145deg, rgba(255,255,255,0.055), rgba(255,255,255,0.02));
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow:
        0 16px 34px rgba(0,0,0,0.22),
        inset 0 1px 0 rgba(255,255,255,0.04);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 22px;
      padding: 24px;
    }

    .section-title{
      display: flex;
      align-items: center;
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 16px;
      color: var(--text-main);
    }

    .section-icon{
      width: 42px;
      height: 42px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.08);
      margin-right: 10px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .premium-label{
      color: var(--text-muted);
      font-weight: 600;
      margin-bottom: 8px;
    }

    .input-group-text.premium-addon{
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      color: var(--text-muted);
      border-radius: 14px 0 0 14px;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    .input-premium-leftfix{
      border-radius: 0 14px 14px 0 !important;
    }

    .soft-divider{
      height: 1px;
      background: linear-gradient(to right, transparent, rgba(255,255,255,0.15), transparent);
      margin: 1.5rem 0;
    }

    .result-box .alert{
      border-radius: 16px;
      margin-bottom: 0;
    }

    .code-highlight{
      display: inline-block;
      margin-top: 10px;
      padding: 12px 16px;
      border-radius: 14px;
      background: rgba(0,209,255,0.10);
      border: 1px solid rgba(0,209,255,0.22);
      color: #9defff;
      font-weight: 800;
      letter-spacing: 1px;
      font-size: 1.1rem;
    }

    .meta-line{
      margin-top: 10px;
      color: var(--text-muted);
      line-height: 1.7;
    }

    .hero-title{
      text-shadow: 0 8px 28px rgba(0,0,0,0.35);
    }

    @media (max-width: 991.98px){
      .generator-card{
        border-radius: 22px;
      }

      .luxury-orb.orb-cyan,
      .luxury-orb.orb-gold,
      .luxury-orb.orb-green{
        transform: scale(0.8);
      }
    }

    @media (max-width: 575.98px){
      .page-shell{
        padding: 18px 0;
      }

      .generator-card{
        border-radius: 18px;
      }

      .brand-chip{
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>

<div class="luxury-orb orb-cyan"></div>
<div class="luxury-orb orb-gold"></div>
<div class="luxury-orb orb-green"></div>

<div class="container page-shell">
  <div class="generator-card p-4 p-md-5">

    <div class="text-center mb-4">
      <div class="brand-chip">
        <i class="bi bi-shield-lock-fill text-cyan"></i>
        Générateur premium de code conférence
      </div>
      <h1 class="hero-title mb-2">Salon de l’Agronomie 2026</h1>
      <p class="page-subtitle">Création sécurisée de codes temporaires pour la validation des participations aux conférences</p>
    </div>

    <div class="inner-panel">
      <div class="section-title">
        <span class="section-icon"><i class="bi bi-key-fill text-gold"></i></span>
        Paramètres de génération
      </div>

      <div class="mb-3">
        <label class="form-label premium-label">ID de l'événement</label>
        <div class="input-group">
          <span class="input-group-text premium-addon">
            <i class="bi bi-hash"></i>
          </span>
          <input type="number" id="event_id" class="form-control input-premium-leftfix" value="1">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label premium-label">Durée de validité (minutes)</label>
        <div class="input-group">
          <span class="input-group-text premium-addon">
            <i class="bi bi-clock-history"></i>
          </span>
          <input type="number" id="valid_minutes" class="form-control input-premium-leftfix" value="15">
        </div>
      </div>

      <div class="d-grid mt-4">
        <button class="btn btn-premium btn-green" onclick="generateCode()">
          <i class="bi bi-lightning-charge-fill me-2"></i>
          Générer le code
        </button>
      </div>

      <div class="soft-divider"></div>

      <div id="result" class="result-box"></div>
    </div>
  </div>
</div>

<script>
async function generateCode() {
    const eventId = document.getElementById("event_id").value;
    const validMinutes = document.getElementById("valid_minutes").value;

    const formData = new FormData();
    formData.append("event_id", eventId);
    formData.append("valid_minutes", validMinutes);

    try {
        const response = await fetch("../api/events.php?action=generate_code", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.ok) {
            document.getElementById("result").innerHTML = `
                <div class="alert alert-premium-success">
                    <div class="fw-bold mb-2">
                        <i class="bi bi-check2-circle me-2"></i>
                        Code généré avec succès
                    </div>

                    <div class="code-highlight">${result.data.code}</div>

                    <div class="meta-line">
                        <strong>Valide de :</strong> ${result.data.valid_from}<br>
                        <strong>Jusqu'à :</strong> ${result.data.valid_to}
                    </div>
                </div>
            `;
        } else {
            document.getElementById("result").innerHTML = `
                <div class="alert alert-premium-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    ${result.error}
                </div>
            `;
        }
    } catch (error) {
        document.getElementById("result").innerHTML = `
            <div class="alert alert-premium-danger">
                <i class="bi bi-wifi-off me-2"></i>
                Erreur lors de la génération du code.
            </div>
        `;
    }
}
</script>

</body>
</html>