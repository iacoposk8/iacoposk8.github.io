import cairosvg

def converti_svg_in_png(input_file, output_file, target_width=24):
    try:
        # CairoSVG gestisce automaticamente il rapporto d'aspetto
        # se viene fornita solo la larghezza (output_width)
        cairosvg.svg2png(
            url=input_file, 
            write_to=output_file, 
            output_width=target_width
        )
        print(f"Conversione completata: {output_file}")
    except Exception as e:
        print(f"Errore durante la conversione: {e}")

import glob
for i in glob.glob("*.svg"):
    converti_svg_in_png(i, i+".png")