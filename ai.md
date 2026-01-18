## AI usage in this project

### Purpose
- Accelerate boilerplate so I could focus on architecture, data flow, and correctness.
- Keep momentum on wording/structure drafts while retaining control over design and naming.

### Tools
- ChatGPT (drafts/reviews)
- Cursor (Composer 1 & Opus 4.5 for inline edits and quick iterations)

### Human-owned decisions
- Architecture boundaries (services + DTOs + Livewire), naming/typing, and layering.
- Cost-rule design and validation of gross/cost/net calculations.
- Ticketmatic query safety, env wiring, and the “no DB footprint” decision.
- Final refactors, error handling, performance considerations, and formatting.

### AI contributions (bounded and edited)
- **Prep:** Summarized Ticketmatic docs and surfaced the needed endpoints (Events list/get, Tools query) to speed up research.
- **Drafts:** Produced Blade/Livewire scaffolds and DTO/service shells to cut boilerplate; I rewrote them to match conventions and structure.
- **Refinement:** Suggested alternative wording/layouts (e.g., README), and occasional styling options; I only kept what fit the direction.

### Guardrails and verification
- Prompts always included constraints: Laravel 12, Livewire 4, Tailwind 4, no database.
- I reviewed AI output for type safety, correct env usage (no `env()` outside config), error handling, and consistency with existing patterns.
- Applied Pint when code was touched and sanity-checked Ticketmatic queries/calculations.
