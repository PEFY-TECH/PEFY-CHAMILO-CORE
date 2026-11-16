# Chamilo native integration qualification — R16
Status: installation not yet executed. This runbook does not claim a deployed plugin.

## Source verification
Canonical fork: PEFY-TECH/PEFY-CHAMILO-CORE, branch pefy/integration-r14.
The fork composer.json requires PHP ^8.3 and GPL-3.0-or-later; it includes H5P, LTI 1.3, Symfony 7.4, API Platform 4, JWT, Stripe and many extensions. These dependencies are NOT evidence that integrations are enabled.

## Stage 0: read-only preflight
```sh
php pefy-distribution/tools/chamilo_preflight.php
php pefy-distribution/tools/verify_preflight.php
```
Outputs structured missing requirements. Never dump .env or credentials.

## Stage 1: isolated deployment
Pin fork commit, verify source and license; provision ephemeral PHP 8.3 + Composer, MariaDB/MySQL matching Chamilo docs, web server and TLS. Run composer install from lockfile without scripts until reviewed. Configure secrets via managed secret store; no public installer. Back up first. Run vendor-documented install/migrations only after review.

## Stage 2: native extension inspection
Inventory actual plugin/theme extension points in this pinned version; build a minimal PEFY-branded module through supported extension points, preserving upstream and GPL notices. Require FR/EN, keyboard, contrast, reduced motion, admin and learner checks. Static pefy-distribution/brand/shell.html is NOT a native integration.

## Stage 3: signed bridge
Define authenticated, tenant-scoped publisher, outbox and receiver. Never accept client supplied authorized=true as proof. Event ID deduplication, replay rejection, revision checks and negative tenant tests. Keep Chamilo DB authoritative for Chamilo records; PEFY PostgreSQL separate.

## Stage 4: vertical E2E
Create synthetic course -> publish -> transport event -> LXP catalog -> enroll learner -> complete H5P/SCORM assessment -> persist grade -> verified skill evidence -> backup/restore and rollback. Capture sanitized traces, run IDs, immutable artifact hashes and human sign-off.

## Release
HOLD until all stages verified. No real user data, financial transactions or production credentials in staging.
