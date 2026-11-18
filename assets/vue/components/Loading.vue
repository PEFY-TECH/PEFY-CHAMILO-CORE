<template>
  <div
    v-if="visible"
    class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 backdrop-blur-sm"
    style="z-index: 10"
    aria-busy="true"
  >
    <div class="pefy-loading" role="status" aria-live="polite">
      <div class="pefy-loading__symbol" aria-hidden="true">📚</div>
      <span class="pefy-loading__label">{{ message }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "Loading",
  props: {
    visible: { type: Boolean, required: true },
    locale: { type: String, default: "fr" },
    messageOverride: { type: String, default: "" },
  },
  computed: {
    message() {
      if (this.messageOverride) return this.messageOverride
      return this.locale.toLowerCase().startsWith("fr")
        ? "Préparation de votre espace d’apprentissage…"
        : "Preparing your learning space…"
    },
  },
}
</script>

<style scoped>
.pefy-loading { display: flex; flex-direction: column; align-items: center; gap: 12px; max-width: 280px; padding: 20px; text-align: center; color: #075985; font: 500 1rem/1.5 system-ui, sans-serif; }
.pefy-loading__symbol { display: grid; place-items: center; width: 68px; height: 68px; border-radius: 20px; background: #e0f2fe; font-size: 34px; animation: pefy-breathe 1.4s ease-in-out infinite; }
@keyframes pefy-breathe { 50% { transform: translateY(-5px) scale(1.04); } }
@media (prefers-reduced-motion: reduce) { .pefy-loading__symbol { animation: none; } }
</style>
