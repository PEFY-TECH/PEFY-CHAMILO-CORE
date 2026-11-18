// Run with: node --test tests/scripts/loading-experience.test.cjs
const { test } = require("node:test")
const assert = require("node:assert/strict")
const fs = require("node:fs")
const path = require("node:path")
const source = fs.readFileSync(path.resolve(__dirname, "../../assets/vue/utils/loadingExperience.js"), "utf8")
const load = import("data:text/javascript;base64," + Buffer.from(source).toString("base64"))

test("loading copy is localized without leaking technical status codes", async () => {
  const { loadingCopy } = await load
  assert.match(loadingCopy("fr").message, /espace/)
  assert.match(loadingCopy("en-US").message, /learning space/)
  assert.equal(loadingCopy("en", "Checking lessons").message, "Checking lessons")
  assert.equal(loadingCopy(null).hint.includes("prêt"), true)
})
test("delay policy clamps invalid, negative and excessive values", async () => {
  const { normalizeLoadingDelay } = await load
  assert.equal(normalizeLoadingDelay(-500), 0)
  assert.equal(normalizeLoadingDelay(200), 200)
  assert.equal(normalizeLoadingDelay(99999), 1500)
  assert.equal(normalizeLoadingDelay(Infinity), 200)
  assert.equal(normalizeLoadingDelay(NaN), 200)
})
