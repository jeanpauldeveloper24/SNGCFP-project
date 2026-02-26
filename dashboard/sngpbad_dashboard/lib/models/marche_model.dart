import 'package:flutter/material.dart';

class MarcheModel {
  final String ref;
  final String objet;
  final String procedure;
  final String stade;
  final Color color; // Maintenant, Color sera reconnu !

  MarcheModel({
    required this.ref,
    required this.objet,
    required this.procedure,
    required this.stade,
    required this.color,
  });
}