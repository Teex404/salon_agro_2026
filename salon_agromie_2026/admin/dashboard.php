<?php
// admin/dashboard.php
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - Salon de l’Agronomie 2026</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body{
      min-height:100vh;
      margin:0;
      color:#eef3f8;
      background:
        radial-gradient(circle at 10% 15%, rgba(0,209,255,0.10), transparent 24%),
        radial-gradient(circle at 88% 12%, rgba(212,175,55,0.09), transparent 22%),
        radial-gradient(circle at 82% 85%, rgba(0,168,107,0.11), transparent 24%),
        linear-gradient(135deg, #05080d 0%, #09111b 30%, #0c1522 65%, #04070b 100%);
      background-attachment: fixed;
      overflow-x:hidden;
    }

    body::before{
      content:"";
      position:fixed;
      inset:0;
      background:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
      background-size:38px 38px;
      opacity:.20;
      pointer-events:none;
      z-index:0;
      mask-image: radial-gradient(circle at center, black 55%, transparent 100%);
      -webkit-mask-image: radial-gradient(circle at center, black 55%, transparent 100%);
    }

    .luxury-orb{
      position:fixed;
      border-radius:50%;
      filter:blur(110px);
      pointer-events:none;
      z-index:0;
      opacity:.95;
    }
    .orb-cyan{ width:360px; height:360px; top:30px; left:20px; background:rgba(0,209,255,.12); }
    .orb-gold{ width:300px; height:300px; top:90px; right:70px; background:rgba(212,175,55,.10); }
    .orb-green{ width:340px; height:340px; bottom:10px; right:80px; background:rgba(0,168,107,.11); }

    .dashboard-shell{
      position:relative;
      z-index:2;
      padding:32px 0 40px;
    }

    .topbar-premium,
    .panel-premium,
    .stat-card{
      background: linear-gradient(145deg, rgba(255,255,255,0.07), rgba(255,255,255,0.025));
      border:1px solid rgba(255,255,255,0.09);
      box-shadow:
        0 20px 50px rgba(0,0,0,0.28),
        inset 0 1px 0 rgba(255,255,255,0.05);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
    }

    .topbar-premium{
      border-radius:24px;
      padding:22px 24px;
      margin-bottom:24px;
      position:relative;
      overflow:hidden;
    }

    .topbar-premium::after{
      content:"";
      position:absolute;
      top:-70px;
      right:-70px;
      width:220px;
      height:220px;
      border-radius:50%;
      background:radial-gradient(circle, rgba(0,209,255,0.14), transparent 65%);
      pointer-events:none;
    }

    .brand-chip{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 14px;
      border-radius:999px;
      background:rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.08);
      color:var(--text-muted, #aab6c5);
      font-size:.92rem;
      margin-bottom:10px;
    }

    .topbar-subtitle{
      color:var(--text-muted, #aab6c5);
      margin-bottom:0;
    }

    .stat-card{
      border-radius:22px;
      padding:20px;
      height:100%;
      position:relative;
      overflow:hidden;
      transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .stat-card:hover{
      transform:translateY(-4px);
      border-color:rgba(0,209,255,.18);
      box-shadow:
        0 24px 60px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.05);
    }

    .stat-icon{
      width:52px;
      height:52px;
      border-radius:16px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      background:rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.08);
      font-size:1.2rem;
      margin-bottom:14px;
    }

    .stat-label{
      color:var(--text-muted, #aab6c5);
      font-size:.92rem;
      margin-bottom:6px;
    }

    .stat-value{
      font-size:2rem;
      font-weight:800;
      color:var(--text-main, #eef3f8);
      line-height:1.1;
    }

    .panel-premium{
      border-radius:24px;
      padding:22px;
      height:100%;
    }

    .section-title{
      display:flex;
      align-items:center;
      gap:10px;
      margin-bottom:18px;
      font-size:1.08rem;
      font-weight:700;
      color:var(--text-main, #eef3f8);
    }

    .section-icon{
      width:42px;
      height:42px;
      border-radius:12px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      background:rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.08);
    }

    .chart-wrap{
      position:relative;
      min-height:330px;
    }

    .table-premium{
      color:#eef3f8;
      margin-bottom:0;
    }

    .table-premium thead th{
      border-bottom:1px solid rgba(255,255,255,.10);
      color:#aab6c5;
      font-weight:600;
      font-size:.92rem;
      background:transparent;
    }

    .table-premium tbody td{
      border-color:rgba(255,255,255,.06);
      vertical-align:middle;
      background:transparent;
    }

    .soft-badge{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 12px;
      border-radius:999px;
      font-size:.85rem;
      font-weight:700;
      border:1px solid transparent;
    }

    .soft-badge.cyan{
      color:#8be9ff;
      background:rgba(0,209,255,.10);
      border-color:rgba(0,209,255,.18);
    }

    .soft-badge.green{
      color:#78f0bc;
      background:rgba(0,168,107,.12);
      border-color:rgba(0,168,107,.18);
    }

    .soft-badge.gold{
      color:#f4d67c;
      background:rgba(212,175,55,.12);
      border-color:rgba(212,175,55,.18);
    }

    .soft-badge.red{
      color:#ff9ea1;
      background:rgba(255,77,109,.10);
      border-color:rgba(255,77,109,.18);
    }

    .empty-box{
      padding:24px;
      border-radius:18px;
      text-align:center;
      color:var(--text-muted, #aab6c5);
      background:rgba(255,255,255,.03);
      border:1px dashed rgba(255,255,255,.10);
    }

    .refresh-btn{
      border-radius:14px;
    }

    @media (max-width: 991.98px){
      .chart-wrap{
        min-height:280px;
      }
    }
  </style>
</head>
<body>

<div class="luxury-orb orb-cyan"></div>
<div class="luxury-orb orb-gold"></div>
<div class="luxury-orb orb-green"></div>

<div class="container-fluid dashboard-shell px-3 px-lg-4">
  <div class="topbar-premium">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
      <div>
        <div class="brand-chip">
          <i class="bi bi-speedometer2 text-info"></i>
          Dashboard administrateur premium
        </div>
        <h1 class="mb-2">Salon de l’Agronomie 2026</h1>
        <p class="topbar-subtitle">
          Vue globale des présences, visites, stands, conférences et points attribués
        </p>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-premium btn-cyan refresh-btn" onclick="loadDashboard()">
          <i class="bi bi-arrow-repeat me-2"></i>Actualiser
        </button>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people-fill text-info"></i></div>
        <div class="stat-label">Étudiants inscrits</div>
        <div class="stat-value" id="statStudents">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-person-check-fill text-success"></i></div>
        <div class="stat-label">Présences validées</div>
        <div class="stat-value" id="statAttendance">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-shop-window text-warning"></i></div>
        <div class="stat-label">Stands</div>
        <div class="stat-value" id="statStands">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-stars text-warning"></i></div>
        <div class="stat-label">Points attribués</div>
        <div class="stat-value" id="statPoints">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-diagram-3-fill text-info"></i></div>
        <div class="stat-label">Total visites stands</div>
        <div class="stat-value" id="statStandVisits">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-mic-fill text-success"></i></div>
        <div class="stat-label">Conférences</div>
        <div class="stat-value" id="statEvents">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-ticket-perforated-fill text-info"></i></div>
        <div class="stat-label">Codes générés</div>
        <div class="stat-value" id="statCodes">0</div>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-person-video3 text-warning"></i></div>
        <div class="stat-label">Participations conférences</div>
        <div class="stat-value" id="statEventAttendance">0</div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-xl-7">
      <div class="panel-premium">
        <div class="section-title">
          <span class="section-icon"><i class="bi bi-bar-chart-fill text-info"></i></span>
          Visites par stand
        </div>
        <div class="chart-wrap">
          <canvas id="standChart"></canvas>
        </div>
      </div>
    </div>

    <div class="col-xl-5">
      <div class="panel-premium">
        <div class="section-title">
          <span class="section-icon"><i class="bi bi-graph-up-arrow text-success"></i></span>
          Évolution des présences
        </div>
        <div class="chart-wrap">
          <canvas id="attendanceChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-xl-7">
      <div class="panel-premium">
        <div class="section-title">
          <span class="section-icon"><i class="bi bi-clock-history text-warning"></i></span>
          Dernières visites de stands
        </div>
        <div class="table-responsive">
          <table class="table table-premium align-middle">
            <thead>
              <tr>
                <th>Étudiant</th>
                <th>Promotion</th>
                <th>Stand</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="recentVisitsTable">
              <tr><td colspan="4"><div class="empty-box">Chargement...</div></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-xl-5">
      <div class="panel-premium">
        <div class="section-title">
          <span class="section-icon"><i class="bi bi-person-lines-fill text-info"></i></span>
          Dernières présences étudiants
        </div>
        <div class="table-responsive">
          <table class="table table-premium align-middle">
            <thead>
              <tr>
                <th>Étudiant</th>
                <th>Promotion</th>
                <th>Statut</th>
              </tr>
            </thead>
            <tbody id="recentAttendanceTable">
              <tr><td colspan="3"><div class="empty-box">Chargement...</div></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let standChartInstance = null;
let attendanceChartInstance = null;

function formatSafe(value){
  return value ?? 0;
}

function badgeHtml(type, text){
  return `<span class="soft-badge ${type}">${text}</span>`;
}

async function fetchJson(url){
  const response = await fetch(url);
  return await response.json();
}

async function loadStats(){
  const result = await fetchJson("../api/admin.php?action=stats");

  if(!result.ok){
    throw new Error(result.error || "Erreur stats");
  }

  const data = result.data || {};

  document.getElementById("statStudents").innerText = formatSafe(data.total_students);
  document.getElementById("statAttendance").innerText = formatSafe(data.total_attendance);
  document.getElementById("statStands").innerText = formatSafe(data.total_stands);
  document.getElementById("statPoints").innerText = formatSafe(data.total_points);
  document.getElementById("statStandVisits").innerText = formatSafe(data.total_stand_visits);
  document.getElementById("statEvents").innerText = formatSafe(data.total_events);
  document.getElementById("statCodes").innerText = formatSafe(data.total_event_codes);
  document.getElementById("statEventAttendance").innerText = formatSafe(data.total_event_attendance);
}

async function loadStandChart(){
  const result = await fetchJson("../api/admin.php?action=visits_by_stand");

  if(!result.ok){
    throw new Error(result.error || "Erreur graphique stands");
  }

  const labels = (result.data || []).map(item => item.stand_name);
  const values = (result.data || []).map(item => Number(item.total_visits));

  const ctx = document.getElementById("standChart").getContext("2d");

  if(standChartInstance){
    standChartInstance.destroy();
  }

  standChartInstance = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [{
        label: "Visites",
        data: values,
        borderWidth: 1,
        borderRadius: 10
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { color: "#dbe7f3" }
        }
      },
      scales: {
        x: {
          ticks: { color: "#aab6c5" },
          grid: { color: "rgba(255,255,255,0.06)" }
        },
        y: {
          beginAtZero: true,
          ticks: { color: "#aab6c5" },
          grid: { color: "rgba(255,255,255,0.06)" }
        }
      }
    }
  });
}

async function loadAttendanceChart(){
  const result = await fetchJson("../api/admin.php?action=attendance_trend");

  if(!result.ok){
    throw new Error(result.error || "Erreur graphique présences");
  }

  const labels = (result.data || []).map(item => item.day_label);
  const values = (result.data || []).map(item => Number(item.total_count));

  const ctx = document.getElementById("attendanceChart").getContext("2d");

  if(attendanceChartInstance){
    attendanceChartInstance.destroy();
  }

  attendanceChartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [{
        label: "Présences",
        data: values,
        tension: 0.35,
        fill: false,
        borderWidth: 3,
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { color: "#dbe7f3" }
        }
      },
      scales: {
        x: {
          ticks: { color: "#aab6c5" },
          grid: { color: "rgba(255,255,255,0.06)" }
        },
        y: {
          beginAtZero: true,
          ticks: { color: "#aab6c5" },
          grid: { color: "rgba(255,255,255,0.06)" }
        }
      }
    }
  });
}

async function loadRecentActivity(){
  const result = await fetchJson("../api/admin.php?action=recent_activity");

  if(!result.ok){
    throw new Error(result.error || "Erreur activités récentes");
  }

  const visits = result.data?.recent_visits || [];
  const attendance = result.data?.recent_attendance || [];

  const visitsTbody = document.getElementById("recentVisitsTable");
  const attendanceTbody = document.getElementById("recentAttendanceTable");

  if(visits.length === 0){
    visitsTbody.innerHTML = `<tr><td colspan="4"><div class="empty-box">Aucune visite récente.</div></td></tr>`;
  } else {
    visitsTbody.innerHTML = visits.map(item => `
      <tr>
        <td>${item.student_name}</td>
        <td>${item.promotion}</td>
        <td>${badgeHtml("cyan", item.stand_name)}</td>
        <td>${item.visited_at}</td>
      </tr>
    `).join("");
  }

  if(attendance.length === 0){
    attendanceTbody.innerHTML = `<tr><td colspan="3"><div class="empty-box">Aucune présence récente.</div></td></tr>`;
  } else {
    attendanceTbody.innerHTML = attendance.map(item => `
      <tr>
        <td>${item.student_name}</td>
        <td>${item.promotion}</td>
        <td>${badgeHtml("green", "Présent")}</td>
      </tr>
    `).join("");
  }
}

async function loadDashboard(){
  try{
    await Promise.all([
      loadStats(),
      loadStandChart(),
      loadAttendanceChart(),
      loadRecentActivity()
    ]);
  } catch(error){
    console.error(error);
    alert("Erreur lors du chargement du dashboard admin.");
  }
}

window.onload = loadDashboard;
</script>
</body>
</html>