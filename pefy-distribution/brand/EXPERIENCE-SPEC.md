# LYSORIA / EULARIS — R14.5 experience specification
Status: design contract, not installed Chamilo theme.
## Identity and product boundaries
- LYSORIA: learner and creator experience (LMS, LCMS, LXP), personal learning and inclusion.
- EULARIS: institutional administration, admissions, credentials, academic workflows and tenant governance.
- HDOS: human development and competencies; no duplication of course gradebook.
- ΩPRAEF™ / PRAEF-EDU: internal quality, assurance and improvement; no external accreditation claim.
- PEFY-GG mother brand assets must remain intact; any derivative must be approved.
## Primary navigation
Learner: Discover / My learning / Practice / Skills / Achievements.
Author: Studio / Assets / Review / Publish / Insights.
Institution: Admissions / Academic records / People / Compliance / Finance.
Consultant: My academy / Learners / Programs / Evidence / Revenue.
Administrator: Tenants / Roles / Security / Audit / Integrations.
## Cross-cutting acceptance
FR/EN localization with future language packs; keyboard and screen reader usability; WCAG 2.2 AA target; responsive 320px+; low-bandwidth budget; offline content with explicit sync conflicts; no fake AI recommendations or grades; multi-tenant ABAC; audit trails.
## Native integration rule
Map each route to the actual Chamilo Vue/Symfony extension point before implementation. Prototype HTML/CSS alone is not native integration. Keep upstream attribution and GPL obligations.
