set terminal png size 1500, 700
set output 'bst-search-measurement.png'
set title 'BST Search Measurement'

set xlabel 'array size'
set ylabel 'execution time'

set yrange [0:10000];
plot "search-measures.dat" with lines
