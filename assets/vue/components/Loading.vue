<template>
  <div
    v-if="visible"
    class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 backdrop-blur-sm"
    style="z-index: 10"
    :aria-busy="visible"
  >
    <div
      v-if="showAnimation"
      class="pefy-loading"
      role="status"
      aria-live="polite"
    >
      <div class="pefy-loading__symbol" aria-hidden="true">📚</div>
      <span class="pefy-loading__label">{{ message }}</span>
      <span class="pefy-loading__subtext">{{ hint }}</span>
    </div>
  </div>
</template>

<script>
import { loadingCopy, normalizeLoadingDelay } from "../utils/loadingExperience"

export default {
  name: "Loading",
  props: {
    visible: { type: Boolean, required: true },
    locale: { type: String, default: "fr" },
    messageOverride: { type: String, default: "" },
    // Avoid visual flicker during fast loads. Never delay the underlying operation.
    delayMs: { type: Number, default: 200 },
  },
  data() {
    return { showAnimation: false, animationTimer: null }
  },
  computed: {
    copy() {
      return loadingCopy(this.locale, this.messageOverride)
    },
    message() {
      return this.copy.message
    },
    hint() {
      return this.copy.hint
    },
  },
  watch: {
    visible: {
      immediate: true,
      handler(value) {
        this.clearAnimationTimer()
        this.showAnimation = false
        if (value) {
          this.animationTimer = setTimeout(() => {
            this.showAnimation = true
            this.animationTimer = null
          }, normalizeLoadingDelay(this.delayMs))
        }
      },
    },
  },
  beforeUnmount() {
    this.clearAnimationTimer()
  },
  methods: {
    clearAnimationTimer() {
      if (this.animationTimer !== null) {
        clearTimeout(this.animationTimer)
        this.animationTimer = null
      }
    },
  },
}
</script>

<style scoped>
.pefy-loading { display: flex; flex-direction: column; align-items: center; gap: 12px; max-width: 310px; padding: 20px; text-align: center; color: #075985; font: 500 1rem/1.5 system-ui, sans-serif; }
.pefy-loading__symbol { display: grid; place-items: center; width: 68px; height: 68px; border-radius: 20px; background: #e0f2fe; font-size: 34px; animation: pefy-breathe 1.4s ease-in-out infinite; }
.pefy-loading__subtext { font-size: .875rem; color: #475569; }
@keyframes pefy-breathe { 50% { transform: translateY(-5px) scale(1.04); } }
@media (prefers-reduced-motion: reduce) { .pefy-loading__symbol { animation: none; } }
</style>
