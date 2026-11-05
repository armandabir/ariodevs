/**
 * Configuration and color palettes for the authentic Motion.dev hero orb / identity field.
 * Sourced directly from Motion.dev's LabIdentityField.
 */

// Motion core mark SVG path (used for markCore point sampling)
export const MOTION_MARK_PATH =
    "M9.587 0 4.57 9H0L3.917 1.972C4.524.883 6.039 0 7.301 0ZM20.794 2.25C20.794 1.007 21.817 0 23.079 0S25.364 1.007 25.364 2.25 24.341 4.5 23.079 4.5 20.794 3.493 20.794 2.25ZM10.443 0H15.013L9.997 9H5.427ZM15.841 0H20.411L16.494 7.028C15.887 8.117 14.372 9 13.11 9H10.825Z";

export const MARK_WIDTH = 25.364;
export const MARK_HEIGHT = 9;
export const MARK_SCALE = 1.7;

// Default field settings from Motion.dev
export const DEFAULT_SETTINGS = {
    brightness: 1.3,
    noise: 0.01,
    pulse: 0.6,
    shell: 0.7,
    spread: 1.3,
    blur: 5,
};

// Shape tune settings for markCore from Motion.dev
export const MARK_CORE_TUNE = {
    logoPoints: 5800,
    size: 0.59,
    depth: 1,
    spin: 0.06,
    reveal: 2.5,
    dotSize: 0.45,
    brightness: 1.9,
    tilt: 10,
};

// Color palettes from Motion.dev
export const PALETTES = {
    gold: [
        [0.85, 0.29, 0.055], // shade (deep warm ember)
        [1.0, 0.86, 0.43],   // light (amber gold)
        [1.0, 0.52, 0.16],   // impact (radiant orange)
    ],
    aiKit: [
        [0.27, 0.1, 0.52],   // deep purple
        [0.88, 0.8, 1.0],    // lavender highlight
        [0.63, 0.42, 0.9],   // electric violet impact
    ],
    blueberry: [
        [0.0, 0.26, 0.57],
        [0.62, 0.81, 1.0],
        [0.24, 0.6, 1.0],
    ],
    dragonfruit: [
        [0.51, 0.08, 0.38],
        [1.0, 0.73, 0.91],
        [0.97, 0.4, 0.76],
    ],
    rind: [
        [0.04, 0.36, 0.2],
        [0.62, 0.96, 0.76],
        [0.32, 0.8, 0.53],
    ],
};

// Grade spectrum colors (used for multi-color grading)
export const GRADE_COLOURS = [
    [0.984, 0.835, 0.035],
    [0.322, 0.804, 0.525],
    [0.243, 0.596, 1.0],
    [0.631, 0.424, 0.898],
    [0.969, 0.404, 0.757],
    [1.0, 0.286, 0.271],
];
