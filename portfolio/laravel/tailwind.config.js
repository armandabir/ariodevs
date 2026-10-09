/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
  ],
  important:true,
  theme: {
   
    fontFamily:{
      'iranSansBold':'iranSans_bold'
    },
   
    extend: {
      colors:{
        'mainBlue':"#111B2F"
       },

      minHeight:{
        'h640':'640px',
        'h-1600':'1600px'
      },

      height:{
        "640":"640px",
        "500":"500px",
        "700":"700px",
        "800":"800px",
        "900":"900px",
        "1600":"1600px",
        "1900":"1900px"

      },

      boxShadow:{
        "myinShadow":"inset 0 0 4px 4px rgb(0 0 0 / 1.00)"
      },

      spacing: {
        '0.75': '0.1875rem',
        '1.25': '0.3125rem',
        '3.75': '0.9375rem',
        '8.75': '2.1875rem',
        '12.5': '3.125rem',
      },

      transitionDuration: {
        '400': '400ms',
        '600': '600ms',
      },

      zIndex: {
        '5': '5',
        '1000': '1000',
        '9999': '9999',
      },

      scale: {
        '102': '1.02',
      },

      backgroundColor: {
        'card': 'var(--bg-card)',
      },


    },
  },
  plugins: [],
}

