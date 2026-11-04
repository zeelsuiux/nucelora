<?php
use App\Config\App;
use App\Helpers\Esc;
?>

<div class="about-page" style="background:#faf9f6; min-height:85vh; padding:40px 0 100px;">
  <div class="w" style="max-width:1100px; margin:0 auto; padding:0 20px;">
    
    <!-- Breadcrumb -->
    <nav style="font-size:13px; color:var(--muted); margin-bottom:28px;">
      <a href="<?= App::baseUrl() ?>" style="color:var(--ink2); text-decoration:none;">Home</a> &rarr; 
      <span style="color:var(--or); font-weight:600;">Our Philosophy &amp; Story</span>
    </nav>

    <!-- Hero Section -->
    <div style="text-align:center; max-width:820px; margin:0 auto 60px;">
      <span style="background:var(--orsoft); color:var(--or); padding:6px 16px; border-radius:99px; font-size:12px; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; border:1px solid rgba(181, 141, 78, 0.25); display:inline-block; margin-bottom:18px;">
        Botanical Intelligence &middot; Cellular Science
      </span>
      <h1 class="h1" style="font-size:42px; font-weight:800; line-height:1.2; margin:0 0 20px; color:var(--ink); font-family:var(--sans);">
        Crafted for visible glow.<br>Inspired by Korean skin science.
      </h1>
      <p style="font-size:17px; line-height:1.7; color:var(--ink2); margin:0;">
        At <b>Nucelora</b>, we believe skincare should be intuitive, deeply restorative, and grounded in transparent dermatological science. We formulate high-potency bio-actives tailored specifically to withstand India’s diverse tropical climates and daily environmental stressors.
      </p>
    </div>

    <!-- Brand Story Grid -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:center; background:#fff; border:1px solid var(--line); border-radius:20px; padding:48px 40px; margin-bottom:60px; box-shadow:0 4px 20px rgba(0,0,0,0.025);" class="story-grid">
      <div>
        <span style="font-size:12px; font-weight:700; color:var(--or); text-transform:uppercase; letter-spacing:0.08em; display:block; margin-bottom:10px;">The Nucelora Story</span>
        <h2 style="font-size:28px; font-weight:700; margin:0 0 18px; color:var(--ink); line-height:1.3;">
          Why Indian Skin Needs a Different Kind of Science
        </h2>
        <p style="font-size:15px; line-height:1.75; color:var(--ink2); margin:0 0 16px;">
          For years, consumers in India had to choose between heavy, pore-clogging creams or generic international formulas that were never engineered for high heat, monsoon humidity, and intense UV exposure.
        </p>
        <p style="font-size:15px; line-height:1.75; color:var(--ink2); margin:0;">
          <b>Nucelora</b> was founded to change that. Drawing inspiration from the meticulous layering philosophies of Seoul's skincare research, we pair fermented botanicals with clinical actives that absorb in seconds, replenish the cellular acid mantle, and protect your moisture barrier without a greasy trace.
        </p>
      </div>
      <div style="text-align:center;">
        <div style="background:var(--soft2); border-radius:16px; padding:36px 24px; border:1px solid var(--line); text-align:center;">
          <img src="<?= App::asset('images/nucelora-logo-cropped.png') ?>" alt="Nucelora Skincare" style="max-height:64px; width:auto; max-width:260px; object-fit:contain; margin-bottom:20px;">
          <blockquote style="margin:0; font-style:italic; font-size:15.5px; color:var(--ink2); line-height:1.6;">
            &ldquo;We don't believe in overnight miracles or toxic shortcuts. We engineer clean, bio-compatible formulas that respect your skin biology today and protect it for decades.&rdquo;
          </blockquote>
          <div style="margin-top:16px; font-size:13px; font-weight:700; color:var(--or);">
            &mdash; The Nucelora Formulation Laboratory
          </div>
        </div>
      </div>
    </div>

    <!-- The 4 Core Pillars Grid -->
    <div style="margin-bottom:70px;">
      <div style="text-align:center; margin-bottom:36px;">
        <span style="font-size:12px; font-weight:700; color:var(--or); text-transform:uppercase; letter-spacing:0.08em;">Our Standards</span>
        <h2 style="font-size:30px; font-weight:700; margin:8px 0 0; color:var(--ink);">The Four Pillars of Nucelora Purity</h2>
      </div>

      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:24px;">
        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:32px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
          <div style="width:48px; height:48px; border-radius:12px; background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); display:flex; align-items:center; justify-content:center; color:var(--or); margin-bottom:20px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:24px; height:24px;"><path d="M12 22v-9"/><path d="M12 13c-4.4 0-8-3.6-8-8 4.4 0 8 3.6 8 8Z"/><path d="M12 13c0-4.4 3.6-8 8-8 0 4.4-3.6 8-8 8Z"/></svg>
          </div>
          <h3 style="font-size:18px; font-weight:700; margin:0 0 10px; color:var(--ink);">Botanical Intelligence</h3>
          <p style="font-size:14px; line-height:1.65; color:var(--ink2); margin:0;">
            Harnessing the soothing strength of fermented rice water, green tea antioxidants, and centella asiatica to calm inflammation and support cellular turnover.
          </p>
        </div>

        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:32px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
          <div style="width:48px; height:48px; border-radius:12px; background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); display:flex; align-items:center; justify-content:center; color:var(--or); margin-bottom:20px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:24px; height:24px;"><path d="M10 2v7.5L4.5 20a1 1 0 0 0 .9 1.5h13.2a1 1 0 0 0 .9-1.5L14 9.5V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/></svg>
          </div>
          <h3 style="font-size:18px; font-weight:700; margin:0 0 10px; color:var(--ink);">Clinical Bio-Actives</h3>
          <p style="font-size:14px; line-height:1.65; color:var(--ink2); margin:0;">
            Precision-dosed 20% Vitamin C, 10% Niacinamide + Zinc, and micro-encapsulated Retinol with proven dermal stability and zero irritation.
          </p>
        </div>

        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:32px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
          <div style="width:48px; height:48px; border-radius:12px; background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); display:flex; align-items:center; justify-content:center; color:var(--or); margin-bottom:20px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:24px; height:24px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
          </div>
          <h3 style="font-size:18px; font-weight:700; margin:0 0 10px; color:var(--ink);">Barrier-First Dermatology</h3>
          <p style="font-size:14px; line-height:1.65; color:var(--ink2); margin:0;">
            Every serum and moisturizer is pH-balanced at 5.5 to safeguard your stratum corneum, locking in long-lasting moisture and repelling pollutants.
          </p>
        </div>

        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:32px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
          <div style="width:48px; height:48px; border-radius:12px; background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); display:flex; align-items:center; justify-content:center; color:var(--or); margin-bottom:20px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:24px; height:24px;"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/><path d="M12 12a3 3 0 0 0 3-3"/></svg>
          </div>
          <h3 style="font-size:18px; font-weight:700; margin:0 0 10px; color:var(--ink);">Clean &amp; 100% Vegan</h3>
          <p style="font-size:14px; line-height:1.65; color:var(--ink2); margin:0;">
            Certified cruelty-free and completely formulated without parabens, sulphates, artificial colorants, phthalates, or harsh silicones.
          </p>
        </div>
      </div>
    </div>

    <!-- Impact Numbers Banner -->
    <div style="background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); border-radius:20px; padding:40px 24px; margin-bottom:70px;">
      <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; text-align:center;" class="numbers-grid">
        <div>
          <div style="font-size:36px; font-weight:800; color:var(--or); line-height:1;">0%</div>
          <div style="font-size:13px; font-weight:600; color:var(--ink); margin-top:8px;">Parabens &amp; Toxins</div>
        </div>
        <div>
          <div style="font-size:36px; font-weight:800; color:var(--or); line-height:1;">100%</div>
          <div style="font-size:13px; font-weight:600; color:var(--ink); margin-top:8px;">Cruelty-Free &amp; Vegan</div>
        </div>
        <div>
          <div style="font-size:36px; font-weight:800; color:var(--or); line-height:1;">98%</div>
          <div style="font-size:13px; font-weight:600; color:var(--ink); margin-top:8px;">Reported Brighter Skin</div>
        </div>
        <div>
          <div style="font-size:36px; font-weight:800; color:var(--or); line-height:1;">50k+</div>
          <div style="font-size:13px; font-weight:600; color:var(--ink); margin-top:8px;">Rituals Delivered in India</div>
        </div>
      </div>
    </div>

    <!-- Call to Action Card -->
    <div style="background:#fff; border:1px solid var(--line); border-radius:20px; padding:50px 32px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.03); max-width:800px; margin:0 auto;">
      <h2 style="font-size:28px; font-weight:800; margin:0 0 12px; color:var(--ink);">Experience the Nucelora Difference</h2>
      <p style="font-size:15px; color:var(--muted); max-width:500px; margin:0 auto 30px; line-height:1.6;">
        Discover which botanical bio-active formula matches your exact skin concern with our free 60-second consultation.
      </p>
      <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
        <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="padding:14px 32px; border-radius:99px; font-size:15px; font-weight:700;">
          Explore All Formulations &rarr;
        </a>
        <a href="<?= App::baseUrl('pages/routine-finder') ?>" class="btn btn-l" style="padding:14px 28px; border-radius:99px; font-size:15px; font-weight:600;">
          Take Routine Finder Quiz
        </a>
      </div>
    </div>

  </div>
</div>

<style>
@media (max-width: 860px) {
  .story-grid {
    grid-template-columns: 1fr !important;
    padding: 30px 20px !important;
  }
  .numbers-grid {
    grid-template-columns: 1fr 1fr !important;
    gap: 24px !important;
  }
}
</style>
