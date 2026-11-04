<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div class="page routine-page" style="padding:60px 0 100px; background:#faf9f6; min-height:85vh;">
  <div class="w" style="max-width:820px; margin:0 auto; padding:0 20px;">
    
    <!-- Top Header -->
    <div style="text-align:center; margin-bottom:44px;">
      <span class="lab o" style="background:var(--orsoft); color:var(--or); padding:6px 18px; border-radius:99px; font-size:12px; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; border:1px solid rgba(181, 141, 78, 0.25); display:inline-block; margin-bottom:14px;">
        AI Skin Consultation
      </span>
      <h1 class="h1" style="font-size:38px; font-weight:800; line-height:1.2; margin:0 0 12px; color:var(--ink);">
        Find your custom ritual in 60 seconds.
      </h1>
      <p style="color:var(--muted); max-width:540px; margin:0 auto; font-size:15.5px; line-height:1.6;">
        Answer 3 quick questions about your skin biology to discover the exact Korean-inspired botanical formula matched to your skin.
      </p>
    </div>

    <!-- Quiz Wizard Card -->
    <div id="quiz-container" style="background:#fff; border:1px solid var(--line); border-radius:20px; padding:40px; box-shadow:0 4px 24px rgba(0,0,0,0.03); overflow:hidden;">
      
      <!-- Progress Bar Track -->
      <div id="quiz-progress-wrap" style="margin-bottom:32px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--or);">
          <span id="progress-text">Step 1 of 3 &middot; Primary Concern</span>
          <span id="progress-pct">33% Completed</span>
        </div>
        <div style="height:6px; background:#f0ece4; border-radius:99px; overflow:hidden;">
          <div id="progress-bar" style="width:33%; height:100%; background:var(--or); border-radius:99px; transition:width 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);"></div>
        </div>
      </div>

      <!-- Step 1 -->
      <div id="step-1" class="quiz-step">
        <h3 style="font-size:22px; font-weight:700; margin:0 0 8px; color:var(--ink);">What is your primary skin concern?</h3>
        <p style="font-size:14px; color:var(--muted); margin:0 0 24px;">Select the main issue you want your routine to target first:</p>
        
        <div class="quiz-options-grid">
          <button type="button" class="quiz-card-opt" onclick="selectAnswer('concern', 'acne', 2)">
            <div class="opt-head">
              <b>Acne &amp; Active Blemishes</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Frequent breakouts, clogged pores, redness, and excess sebum production.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="selectAnswer('concern', 'pigmentation', 2)">
            <div class="opt-head">
              <b>Dark Spots &amp; Dullness</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Sun spots, post-acne hyperpigmentation, uneven skin tone, and lack of glow.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="selectAnswer('concern', 'anti-aging', 2)">
            <div class="opt-head">
              <b>Fine Lines &amp; Elasticity</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Loss of skin firmness, crow's feet, smile lines, and mature renewal needs.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="selectAnswer('concern', 'hydration', 2)">
            <div class="opt-head">
              <b>Dryness &amp; Dehydration</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Tight sensation after washing, flaky patches, and compromised barrier.</p>
          </button>
        </div>
      </div>

      <!-- Step 2 -->
      <div id="step-2" class="quiz-step" hidden>
        <h3 style="font-size:22px; font-weight:700; margin:0 0 8px; color:var(--ink);">How would you describe your skin type?</h3>
        <p style="font-size:14px; color:var(--muted); margin:0 0 24px;">How your bare skin feels a few hours after washing:</p>
        
        <div class="quiz-options-grid">
          <button type="button" class="quiz-card-opt" onclick="selectAnswer('skin_type', 'oily', 3)">
            <div class="opt-head">
              <b>Oily / Combination</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Visible shine in the T-zone (forehead and nose) by midday, prone to open pores.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="selectAnswer('skin_type', 'dry', 3)">
            <div class="opt-head">
              <b>Dry / Parched</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Feels tight, rough, or uncomfortably stretched unless moisturized immediately.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="selectAnswer('skin_type', 'sensitive', 3)">
            <div class="opt-head">
              <b>Sensitive &amp; Reactive</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Prone to stinging, facial redness, itching, or allergic reactions to heavy products.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="selectAnswer('skin_type', 'normal', 3)">
            <div class="opt-head">
              <b>Balanced / Normal</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Generally comfortable with healthy hydration, neither overly oily nor dry.</p>
          </button>
        </div>
      </div>

      <!-- Step 3 -->
      <div id="step-3" class="quiz-step" hidden>
        <h3 style="font-size:22px; font-weight:700; margin:0 0 8px; color:var(--ink);">What daily routine complexity do you prefer?</h3>
        <p style="font-size:14px; color:var(--muted); margin:0 0 24px;">Choose the routine duration that fits your daily lifestyle:</p>
        
        <div class="quiz-options-grid">
          <button type="button" class="quiz-card-opt" onclick="finishQuiz('minimal')">
            <div class="opt-head">
              <b>Quick &amp; Minimal (2-3 mins)</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Streamlined ritual: Targeted treatment serum + broad spectrum daily SPF protection.</p>
          </button>

          <button type="button" class="quiz-card-opt" onclick="finishQuiz('complete')">
            <div class="opt-head">
              <b>Complete Holistic Ritual (5 mins)</b>
              <span class="opt-indicator"></span>
            </div>
            <p>Full Korean-inspired regimen: Gentle Cleanse + Targeted Treat + Moisture Barrier + SPF Shield.</p>
          </button>
        </div>
      </div>

      <!-- Result Screen -->
      <div id="quiz-result" hidden style="text-align:center;">
        <div style="width:64px; height:64px; background:#dcfce7; color:#15803d; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px; border:1px solid #bbf7d0;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:30px; height:30px;"><path d="m5 13 4 4L19 7"/></svg>
        </div>
        <span class="lab o" style="background:var(--orsoft); color:var(--or); padding:5px 14px; border-radius:99px; font-size:12px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;">Personalized Diagnosis</span>
        <h2 class="h2" id="res-title" style="font-size:28px; font-weight:800; margin:12px 0 8px; color:var(--ink);">Recommended: Daily Radiance Routine</h2>
        <p id="res-desc" style="color:var(--muted); max-width:540px; margin:0 auto 28px; font-size:15px; line-height:1.6;"></p>

        <div id="res-products" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:36px; text-align:left;">
          <!-- Dynamically filled with products -->
        </div>

        <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
          <button type="button" id="btn-add-ritual" class="btn btn-k" onclick="addAllRecommended()" style="padding:14px 32px; border-radius:99px; font-size:15px; font-weight:700;">
            Add Entire Ritual to Bag &rarr;
          </button>
          <button type="button" class="btn btn-l" onclick="location.reload()" style="padding:14px 24px; border-radius:99px; font-size:14px; font-weight:600;">
            Retake Quiz
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
.quiz-options-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 16px;
  width: 100%;
  box-sizing: border-box;
}

.quiz-card-opt {
  display: flex !important;
  flex-direction: column !important;
  align-items: flex-start !important;
  text-align: left !important;
  white-space: normal !important;
  width: 100% !important;
  min-width: 0 !important;
  height: auto !important;
  min-height: 110px;
  background: #fff !important;
  border: 1.5px solid var(--line) !important;
  border-radius: 14px !important;
  padding: 20px 18px !important;
  cursor: pointer;
  box-sizing: border-box !important;
  transition: all 0.2s cubic-bezier(0.2, 0.8, 0.2, 1);
  font-family: inherit;
  color: var(--ink);
  outline: none;
  overflow: hidden;
  word-wrap: break-word;
}

.quiz-card-opt:hover {
  border-color: var(--or) !important;
  background: var(--orsoft) !important;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(181, 141, 78, 0.12);
}

.quiz-card-opt .opt-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  margin-bottom: 8px;
}

.quiz-card-opt .opt-head b {
  font-size: 15.5px;
  font-weight: 700;
  color: var(--ink);
  line-height: 1.3;
}

.quiz-card-opt .opt-indicator {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  border: 1.5px solid #d4cebe;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: all 0.2s;
}

.quiz-card-opt:hover .opt-indicator {
  border-color: var(--or);
  background: var(--or);
  box-shadow: inset 0 0 0 3px #fff;
}

.quiz-card-opt p {
  font-size: 13px;
  color: var(--muted);
  line-height: 1.5;
  margin: 0;
  font-weight: normal;
}

@media (max-width: 700px) {
  #quiz-container {
    padding: 24px 18px !important;
    border-radius: 16px !important;
  }
  .quiz-options-grid {
    grid-template-columns: 1fr !important;
  }
}
</style>

<script>
const quizAnswers = {};
const allCatalog = <?= json_encode($catalog ?? []) ?>;

function updateProgress(stepNum) {
  const bar = document.getElementById('progress-bar');
  const txt = document.getElementById('progress-text');
  const pct = document.getElementById('progress-pct');

  if (stepNum === 2) {
    bar.style.width = '66%';
    txt.textContent = 'Step 2 of 3 · Skin Type';
    pct.textContent = '66% Completed';
  } else if (stepNum === 3) {
    bar.style.width = '100%';
    txt.textContent = 'Step 3 of 3 · Routine Preference';
    pct.textContent = '100% Completed';
  }
}

function selectAnswer(key, val, nextStep) {
  quizAnswers[key] = val;
  document.querySelectorAll('.quiz-step').forEach(s => s.hidden = true);
  document.getElementById('step-' + nextStep).hidden = false;
  updateProgress(nextStep);
}

function finishQuiz(complexity) {
  quizAnswers['complexity'] = complexity;
  document.querySelectorAll('.quiz-step').forEach(s => s.hidden = true);
  document.getElementById('quiz-progress-wrap').hidden = true;
  document.getElementById('quiz-result').hidden = false;

  const concern = quizAnswers['concern'] || 'acne';
  let title = "Daily Radiance Ritual";
  let desc = "Formulated to balance cellular hydration and deliver lasting natural luminosity without clogging pores.";
  let selected = [];

  if (concern === 'acne') {
    title = "Complete Acne Defense Ritual";
    desc = "Salicylic acid and fermented rice water actives soothe irritation, reduce breakouts, and regulate excess sebum.";
    selected = allCatalog.filter(p => p.slug.includes('acne') || p.slug.includes('wash') || p.slug.includes('sunscreen')).slice(0, 3);
  } else if (concern === 'pigmentation') {
    title = "Pigmentation & Glow Ritual";
    desc = "Clinically active 3-O-Ethyl Ascorbic Acid and Alpha Arbutin fade stubborn dark spots and restore an even, luminous complexion.";
    selected = allCatalog.filter(p => p.slug.includes('pigmentation') || p.slug.includes('vitamin-c') || p.slug.includes('moisturizer')).slice(0, 3);
  } else if (concern === 'anti-aging') {
    title = "Age Defense Renewal Ritual";
    desc = "Encapsulated Retinol, Peptides, and Hyaluronic Acid accelerate healthy cellular turnover for supple, firm, youthful skin.";
    selected = allCatalog.filter(p => p.slug.includes('retinol') || p.slug.includes('night') || p.slug.includes('under-eye')).slice(0, 3);
  } else {
    title = "Deep Hydration Barrier Ritual";
    desc = "Sodium Hyaluronate and Vitamin E nourish parched dermal layers and lock in 24-hour restorative hydration.";
    selected = allCatalog.filter(p => p.slug.includes('moisturizer') || p.slug.includes('niacinamide') || p.slug.includes('sunscreen')).slice(0, 3);
  }

  if (selected.length === 0) selected = allCatalog.slice(0, 3);

  document.getElementById('res-title').textContent = title;
  document.getElementById('res-desc').textContent = desc;

  const cont = document.getElementById('res-products');
  cont.innerHTML = '';
  selected.forEach((p, idx) => {
    const steps = ['Step 1: Cleanse / Prep', 'Step 2: Targeted Active Treatment', 'Step 3: Barrier Hydration & Protect'];
    cont.innerHTML += `
      <div style="background:#fff; border:1px solid var(--line); border-radius:12px; padding:16px; display:flex; flex-direction:column; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
        <div style="aspect-ratio:1/1; background:var(--soft2); border-radius:8px; overflow:hidden; margin-bottom:12px; text-align:center;">
          <img src="${p.image_url}" alt="${p.title}" style="width:100%; height:100%; object-fit:contain;">
        </div>
        <span style="font-size:11px; font-weight:700; color:var(--or); text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px;">${steps[idx] || 'Recommended Step'}</span>
        <b style="font-size:14.5px; color:var(--ink); margin-bottom:8px; line-height:1.35;">${p.title}</b>
        <div style="margin-top:auto; font-weight:700; color:var(--or); font-size:15px; border-top:1px dashed var(--line); padding-top:10px;">
          Rs. ${Number(p.price).toLocaleString('en-IN')}
        </div>
      </div>
    `;
  });

  window.__recProducts = selected;
}

async function addAllRecommended() {
  if (!window.__recProducts || !window.__recProducts.length) return;
  const btn = document.getElementById('btn-add-ritual');
  btn.disabled = true;
  btn.textContent = 'Adding ritual to bag...';

  const items = window.__recProducts.map(p => ({ id: p.id, quantity: 1 }));
  try {
    const res = await fetch('<?= App::baseUrl('cart/add') ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ items })
    });
    if (res.ok) {
      document.dispatchEvent(new CustomEvent('cart:refresh'));
      if (window.Lymko && window.Lymko.openO) {
        window.Lymko.openO('cart');
      }
      btn.textContent = '✓ Ritual Added!';
    }
  } catch (e) {
    btn.disabled = false;
    btn.textContent = 'Add Entire Ritual to Bag →';
    alert('Could not add items. Please try again.');
  }
}
</script>
