set terminal png size 1500, 700
set output 'bst-delete-measurement.png'
set title 'BST Delete Measurement'

set xlabel 'array size'
set ylabel 'execution time'

# set yrange [200:1000];
plot "delete-measures.dat" with lines
