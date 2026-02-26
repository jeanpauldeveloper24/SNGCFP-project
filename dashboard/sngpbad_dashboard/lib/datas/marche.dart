import 'package:flutter/material.dart';

class MarcheData {
  final String ref;
  final String objet;
  final String procedure;
  final String stade;
  final Color color;
  final bool isConforme; // Nouveau : Statut de validation par le spécialiste Web

  MarcheData({
    required this.ref, 
    required this.objet, 
    required this.procedure, 
    required this.stade, 
    required this.color,
    this.isConforme = false, // Par défaut, non vérifié
  });
}
