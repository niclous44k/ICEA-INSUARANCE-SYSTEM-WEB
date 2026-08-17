# ICEA-INSUARANCE-SYSTEM-WEB
ICEA INSUARANCE SYSTEM WEB
# ICEA LION Insurance — Website

A responsive multi-page website for **ICEA LION Insurance**, showcasing the company's insurance products, brand information, and customer contact channels. Built with HTML5, custom CSS, and Bootstrap 5.

🔗 **Live Demo:** _[Add your GitHub Pages / hosting link here]_

---

## 📄 Pages

| Page | File | Description |
|------|------|-------------|
| Home | `index.html` | Hero video banner, insurance product highlights (Life, Health, Motor), an image carousel, and sign-up / quote request modals. |
| About Us | `about_us.html` | Company overview, mission, vision, values, "Why Choose Us" section, and an embedded Google Map. |
| Insurance Plan | `insuarance_plan.html` | Grid of insurance products (Life, Health, Motor, Home, Travel, Business) with a "Why Choose Our Insurance?" benefits section and call-to-action. |
| Contact Us | `contact_us.html` | Contact form with insurance-type selector, plus office address, phone, email, and working hours. |

## ✨ Features

- Fully responsive layout using **Bootstrap 5.3.8**
- Autoplaying background hero video on the homepage
- Interactive Bootstrap modals for "Sign Up" and "Request a Quote"
- Image carousel highlighting key insurance offerings
- Embedded Google Maps location on the About Us page
- Custom hover animations on cards and floating hero text effects
- Consistent branded navigation and footer across all pages

## 🛠️ Built With

- **HTML5** — page structure and content
- **CSS3** (`style.css`) — custom styling, animations, and responsive tweaks
- **[Bootstrap 5.3.8](https://getbootstrap.com/)** — responsive grid, components, and modals
- **Bootstrap Icons / Bootstrap Bundle JS** — interactive UI components

## 📁 Project Structure

```
├── index.html              # Homepage
├── about_us.html           # About Us page
├── insuarance_plan.html    # Insurance Plan page
├── contact_us.html         # Contact Us page
├── style.css                # Custom stylesheet
└── README.md                 # Project documentation
```

## 🚀 Getting Started

To run this project locally:

1. Clone the repository
   ```bash
   git clone https://github.com/<your-username>/<your-repo-name>.git
   ```
2. Navigate into the project folder
   ```bash
   cd <your-repo-name>
   ```
3. Open `index.html` in your browser, or serve it with a local development server (e.g. the VS Code **Live Server** extension) for the best experience.

No build tools, package managers, or dependencies are required — this is a static site that runs entirely in the browser (Bootstrap is loaded via CDN).

## ⚠️ Known Issues / To-Do

- File names currently mix cases and hyphens/underscores/spaces (e.g. `about us.HTML` vs `about_us.HTML`) — internal `<a href>` links across pages should be standardized to match the actual file names exactly, since links are case- and space-sensitive on most hosts (including GitHub Pages).
- Some `<a>` links point to placeholder or unrelated domains — update these to point to their actual page/section.
- A few `<h1>` tags on the homepage have malformed closing tags — worth a quick HTML validation pass.
- Consider adding `alt` text improvements and ARIA labels for full accessibility compliance.
- Add real screenshots/GIFs to this README once the site is live.

## 📬 Contact

**ICEA LION Insurance**
📧 info@icealion.co.ke
📞 +254 20 2221973
📍 ICEA LION Centre, Riverside Park, Nairobi, Kenya

## 📝 License

This project is intended for educational/portfolio purposes. All ICEA LION branding, logos, and trademarks belong to their respective owner.
