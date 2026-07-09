---
name: "pinterest-design-system"
description: "Pinterest-style design system reference. Invoke when building UI components, styling with Tailwind CSS, choosing colors/typography/spacing, or making any frontend design decisions."
---

# Pinterest Design System

Reference: `g:\warungmember\DESIGN.md` — authoritative source. This skill summarizes key tokens and rules for daily use.

## Colors

| Token | Hex | Role |
|---|---|---|
| `primary` | `#e60023` | Pinterest Red — CTA only. Never decorative. |
| `primary-pressed` | `#cc001f` | Pressed primary |
| `ink` | `#000000` | Headlines, button text, nav links |
| `ink-soft` | `#211922` | Inline body links only |
| `body` | `#33332e` | Default paragraph |
| `mute` | `#62625b` | Metadata, footer, secondary captions |
| `ash` | `#91918c` | Disabled text, placeholders |
| `stone` | `#c8c8c1` | Least-emphasis utility |
| `canvas` | `#ffffff` | True white — nav, modals, feature cards |
| `surface-soft` | `#fbfbf9` | Page body wash |
| `surface-card` | `#f6f6f3` | Warm-cream card/pin-tile bg |
| `secondary-bg` | `#e5e5e0` | Secondary button fill |
| `secondary-pressed` | `#c8c8c1` | Pressed secondary |
| `surface-dark` | `#262622` | Dark CTA strip |
| `hairline` | `#dadad3` | 1px dividers |
| `hairline-soft` | `#e5e5e0` | Lighter dividers |
| `focus-outer` | `#435ee5` | Focus ring outer |
| `focus-inner` | `#ffffff` | Focus ring inner gap |
| `error` | `#9e0a0a` | Validation errors |
| `success-deep` | `#103c25` | Success messaging |
| `success-pale` | `#c7f0da` | Success pill bg |

## Typography

Font: **Inter** (substitute for Pin Sans). Weights: 400, 500, 600, 700.

| Token | Size | Weight | Line | Tracking | Use |
|---|---|---|---|---|---|
| `display-xl` | 70px | 600 | 1.1 | -1.2px | Hero headline |
| `display-lg` | 44px | 700 | 1.15 | -0.8px | Secondary hero |
| `heading-xl` | 28px | 700 | 1.2 | -1.2px | Section heading |
| `heading-lg` | 22px | 600 | 1.25 | 0 | Modal title |
| `heading-md` | 18px | 600 | 1.3 | 0 | Card title |
| `body-md` | 16px | 400 | 1.4 | 0 | Default body |
| `body-strong` | 16px | 600 | 1.4 | 0 | Emphasis, nav link, label |
| `body-sm` | 14px | 400 | 1.4 | 0 | Footer, metadata, helper |
| `body-sm-strong` | 14px | 700 | 1.4 | 0 | Count labels, table headers |
| `caption-md` | 12px | 500 | 1.5 | 0 | Captions |
| `caption-sm` | 12px | 400 | 1.4 | 0 | Smallest utility |
| `link-md` | 16px | 600 | 1.4 | 0 | Inline anchor |
| `button-md` | 14px | 700 | 1 | 0 | Button label |
| `button-sm` | 12px | 700 | 1 | 0 | Compact pill chip |

## Border Radius

| Token | Value | Use |
|---|---|---|
| `none` | 0px | Footer, nav, structural surfaces |
| `sm` | 8px | Rare (tooltips) |
| `md` | 16px | **Dominant** — buttons, inputs, cards, tiles |
| `lg` | 32px | Large cards, modals |
| `full` | 9999px | Search bar, chips, pills, avatars |

## Spacing

| Token | Value | Use |
|---|---|---|
| `xxs` | 4px | Tight inline gaps |
| `xs` | 6px | Pill/chip internals |
| `sm` | 8px | **Pin grid gutters** |
| `md` | 12px | General |
| `lg` | 16px | Component padding |
| `xl` | 24px | Section internal |
| `xxl` | 32px | Modal/card padding |
| `section` | 64px | Vertical section rhythm |

## Key Components

### Buttons
- **primary**: `bg-[#e60023] text-white` rounded-2xl (16px), h-10, px-3.5 py-1.5, text-sm font-bold. Pressed: `bg-[#cc001f]`.
- **secondary**: `bg-[#e5e5e0] text-black` rounded-2xl, h-10. Pressed: `bg-[#c8c8c1]`.
- **tertiary**: transparent, `text-black`, rounded-2xl.
- **icon-circular**: `bg-[#f6f6f3]` rounded-full, 40×40.
- **pill-on-image**: `bg-white text-black` rounded-full, px-3.5 py-2, text-sm font-bold.
- **disabled**: `bg-[#f6f6f3] text-[#91918c]`.

### Inputs
- **text-input**: `bg-white`, 1px `border-[#91918c]`, rounded-2xl, h-11, px-[15px] py-[11px], text-base. Focus: 2px `border-black` inner + 4px `ring-[#435ee5]` outer.
- **search-bar**: `bg-[#f6f6f3]`, rounded-full, h-12, px-[15px] py-[11px]. Focus: `bg-white`, 1px `border-[#91918c]`.

### Cards
- **pin-card**: `bg-[#f6f6f3]` rounded-2xl, p-0. Image full-bleed, no internal padding.
- **pin-card-large**: same but rounded-3xl (32px).
- **category-tile**: `bg-[#f6f6f3]` rounded-2xl, p-4, 1:1 thumbnails + label in body-strong.
- **feature-card**: `bg-white` rounded-2xl, p-8. 4:5 image + heading-xl headline + body + CTA.
- **feature-card-soft**: same but `bg-[#f6f6f3]`.
- **modal-card**: `bg-white` rounded-3xl, p-8, 16px ambient shadow over 50% scrim.

### Chips
- **filter-chip**: `bg-[#f6f6f3] text-black` rounded-full, px-4 py-2.
- **filter-chip-active**: `bg-black text-white` rounded-full.

### Navigation
- **primary-nav**: `bg-white`, h-16, no rounded. 1px `border-[#dadad3]` bottom rule on inner pages.
- Layout: logo left, search center, "Log in" + red "Sign up" CTA right.

### Overlay Pill
- `bg-white text-black` rounded-full, px-3 py-1.5, text-xs font-bold. Anchored on pin imagery.

## Rules (Do's and Don'ts)

### Do
- Reserve `#e60023` for primary CTAs and active indicators only. Never decorative.
- Use `rounded-2xl` (16px) on every interactive element and card. `rounded-3xl` (32px) only for large cards/modals. `rounded-full` for circular.
- Pin cards have zero internal padding — image is full-bleed.
- Section rhythm: 64px vertical gaps. Pin grid gutters: 8px.
- Hierarchy from weight (400→600→700) and size, not color tinting.
- Apply `tracking-[-1.2px]` on display-xl and heading-xl.

### Don't
- No sharp-cornered buttons or cards. Zero `rounded-none` interactive elements.
- No drop shadows on cards. Only shadow: modal 16px ambient.
- No padding inside pin-card. Metadata overlays the image, not below it.
- Never replace `#e60023` with another red.
- `#211922` (ink-soft) only for inline body links — not chrome.
- No third radius between 16px and 32px. Jump directly md→lg.

## Responsive Breakpoints

| Name | Width | Grid |
|---|---|---|
| ultrawide | 1920px+ | 5-6 cols |
| desktop-large | 1440px | 4 cols |
| desktop-small | 1024px | 3 cols |
| tablet | 768px | 2 cols, hamburger nav |
| mobile | 480px | 1 col, hero 70→44px |
| mobile-narrow | 320px | hero 44→36px |

All interactive elements ≥ 44×44px touch target. Red Sign-up CTA visible at every breakpoint.
