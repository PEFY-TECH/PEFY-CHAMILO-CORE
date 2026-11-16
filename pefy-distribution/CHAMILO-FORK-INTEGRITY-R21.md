# R21 — Chamilo fork source-integrity verification
Date: 2026-11-16
Canonical fork: PEFY-TECH/PEFY-CHAMILO-CORE
Upstream reference: chamilo/chamilo-lms (GitHub default branch master)
Customization branch: pefy/integration-r14

## Directly verified GitHub evidence
- Fork repository exists, public, GitHub reported repository size 1,733,690 KB. This is repository storage metadata, NOT a completeness certificate.
- Fork master and pefy/integration-r14 both contain composer.lock (same Git blob SHA fa921669ecce3da7508ec24348edbdcc30c3718f), license.txt (b3f5f170d50e894a73e9b9ccb6b6dcc659a21215), src/Kernel.php (c0cb51ef2d54df673718bbda4a75666afbe8d2d3), and public/index.php (f8eb1b3a69de0805d56db2caf9c4ffea9dd326ea).
- GitHub compare master...pefy/integration-r14: ahead_by=9, behind_by=0, 9 commits, 9 added files, no modified/deleted upstream files reported. All nine additions are under pefy-distribution/ except the new preflight workflow.
- Consequently the PEFY customization branch inherits the existing fork master source and currently keeps its changes additive. Do NOT reupload a second duplicate Chamilo tree into pefy-distribution.

## Not yet verified
- Whether fork master is a true GitHub fork of chamilo/chamilo-lms, its exact upstream commit, complete tree equality, tags, LFS objects, submodules and all assets.
- Whether upstream changed since the fork was taken. Repository sizes of upstream and fork are similar but not proof of parity.
- Composer install, frontend build, database migrations, security advisories, running Chamilo, native PEFY extension and E2E.

## Mandatory next source-integrity checks
1. Capture fork parent/upstream relationship and pinned commit SHAs through repository metadata/git.
2. Compare full Git tree against pinned upstream revision, check LFS/submodules and git integrity (git fsck).
3. Inventory full source directories, lockfiles, licenses, third-party asset provenance and executable build prerequisites.
4. Preserve upstream branch; customize only on feature branches with reviewed commits, CI and GPL license obligations.
5. Update from upstream through reviewed merge/rebase after compatibility testing; never force overwrite canonical history.
6. Never publish installer or deploy public environment until complete acceptance and explicit approval.

Release status: HOLD. The full source base is substantially present in the fork; complete upstream parity remains UNVERIFIED.
