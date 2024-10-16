---
layout: default
title: Ebook to covers in library
---

# Ebook to covers in library

![sample to result image](covers.jpg)

I have developed a Python script that converts a folder containing EPUB and PDF files into an image where the books are displayed as if they were physical volumes neatly arranged on a bookshelf. The script automatically extracts the cover images and titles from the digital files, creating a visually representation of the books, just as if they were sitting on a real shelf. This allows you to easily visualize your eBook collection in a more tangible and organized way.

To make the script work, you need to modify two lines of code. First, update `base_path = "~/Desktop/Book"` with the actual path to the folder containing your eBooks. Second, you can optionally use the `blacklist = []` variable to specify a list of words; any titles containing these words will be excluded from the final image. This provides flexibility in managing how your book collection is displayed.

<a target="_blank" href="https://colab.research.google.com/github/iacoposk8/colabs/blob/main/Ebook2covers.ipynb">
  <img src="https://colab.research.google.com/assets/colab-badge.svg" alt="Open In Colab"/>
</a>
