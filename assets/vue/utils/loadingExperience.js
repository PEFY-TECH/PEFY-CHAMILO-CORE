// Dependency-free loading policy shared by the Vue loader and tests.
// Delay avoids flashing an animation for an operation that finishes immediately.
export function normalizeLoadingDelay(value) {
  return Number.isFinite(value) ? Math.min(1500, Math.max(0, value)) : 200
}
export function loadingCopy(locale, override = "") {
  const french = String(locale || "fr").toLowerCase().startsWith("fr")
  return {
    message: override || (french ? "Préparation de votre espace d’apprentissage…" : "Preparing your learning space…"),
    hint: french ? "Votre espace s’ouvrira dès qu’il sera prêt." : "Your space will open as soon as it is ready.",
  }
}
