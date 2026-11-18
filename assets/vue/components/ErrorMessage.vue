<template>
  <div class="alert alert-danger pefy-friendly-error" role="alert">
    <span class="pefy-friendly-error__icon" aria-hidden="true">💡</span>
    <div>
      <strong>{{ friendlyTitle }}</strong>
      <p class="mb-0">{{ friendlyDescription }}</p>
    </div>
  </div>
</template>

<script>
const MESSAGES = {
  fr: {
    400: ["La demande n'a pas pu être traitée", "Vérifiez les informations saisies et réessayez."],
    401: ["Votre session a expiré", "Reconnectez-vous pour continuer."],
    403: ["Cet espace est protégé", "Vous n'avez pas l'autorisation nécessaire pour cette action."],
    404: ["Ce contenu est introuvable", "Il a peut-être changé d'adresse. Revenez à votre espace d'apprentissage."],
    408: ["Le chargement prend du temps", "Vérifiez votre connexion et réessayez."],
    429: ["Un peu de patience", "Trop de demandes ont été envoyées. Réessayez dans quelques instants."],
    500: ["Un souci technique est survenu", "Veuillez réessayer plus tard."],
    502: ["Service momentanément perturbé", "Veuillez réessayer dans quelques instants."],
    503: ["Service temporairement indisponible", "Revenez dans quelques instants."],
    504: ["Le service tarde à répondre", "Veuillez réessayer dans quelques instants."],
    default: ["Cette action n'a pas abouti", "Réessayez ou contactez l'assistance si le problème persiste."],
  },
  en: {
    400: ["We couldn't process your request", "Check your information and try again."],
    401: ["Your session has expired", "Sign in again to continue."],
    403: ["This area is restricted", "You don't have permission for this action."],
    404: ["We couldn't find this content", "It may have moved. Return to your learning space."],
    408: ["This is taking longer than expected", "Check your connection and try again."],
    429: ["Please wait a moment", "Too many requests were sent. Try again shortly."],
    500: ["Something went wrong", "Please try again later."],
    502: ["Service temporarily interrupted", "Please try again shortly."],
    503: ["Service temporarily unavailable", "Come back in a few moments."],
    504: ["The service is taking too long", "Please try again shortly."],
    default: ["We couldn't complete this action", "Try again or contact support if this continues."],
  },
}

export default {
  name: "ErrorMessage",
  props: {
    error: { type: [Error, Object], required: true },
    locale: { type: String, default: "fr" },
  },
  computed: {
    friendlyPair() {
      const language = this.locale.toLowerCase().startsWith("fr") ? "fr" : "en"
      const status = Number(this.error?.response?.status)
      return MESSAGES[language][status] || MESSAGES[language].default
    },
    friendlyTitle() { return this.friendlyPair[0] },
    friendlyDescription() { return this.friendlyPair[1] },
  },
}
</script>

<style scoped>
.pefy-friendly-error { display: flex; gap: 12px; align-items: flex-start; }
.pefy-friendly-error__icon { font-size: 1.4rem; }
</style>
