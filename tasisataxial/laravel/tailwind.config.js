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
      }


    },
  },
  plugins: [],
}

