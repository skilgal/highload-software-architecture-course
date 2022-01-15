#!/usr/bin/env python3

#Binary Search Tree Implementation - www.101computing.net/binary-search-tree-implementation/

#A class to implement a Node / Binary Search Tree
class BST:
  def __init__(self, value, left=None, right=None):
    self.value = value
    self.left = left
    self.right = right


  #Binary Search
  def find(self, value):
    node=self
    while node:
        if value < node.value:
            node = node.left
        elif value > node.value:
            node = node.right
        else:
            return node

  #Return the smallest (most left) value of the BST
  def min(self):
    node=self
    while node and node.left:
        node = node.left
    return node

  #Return the largest (most right) value of the BST
  def max(self):
    node=self
    while node and node.right:
        node = node.right
    return node

  #Insert value into node by following BST properties
  def insert(self, value, node=None, root=True):
    if root:
      node=self

    if node is None:
        return BST(value)

    if value < node.value:
        node.left = self.insert(value, node.left, False)

    elif value > node.value:
        node.right = self.insert(value, node.right, False)
    else:
        #Duplicate value, ignore it
        return node
    return node

  #Deletes node from the tree. Return a pointer to the resulting tree
  def delete(self, value, node=None, root=True):
    if root:
      node=self

    if node is None:
        return None

    if value < node.value:
        node.left = self.delete(value, node.left, False)
    elif value > node.value:
        node.right = self.delete(value, node.right, False)
    elif node.left and node.right:
        tmp_cell = self.min()
        node.value = tmp_cell.value
        node.right = self.delete(node.value, node.right, False)
    else:
        if node.left is None:
            node = node.right
        elif node.right is None:
            node = node.left

