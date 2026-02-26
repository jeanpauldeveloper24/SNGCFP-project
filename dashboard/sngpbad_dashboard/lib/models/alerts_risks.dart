import 'package:flutter/material.dart';

class RiskModel {
  final int id;             // Nécessaire pour l'archivage via l'API
  final String title;       // Titre du risque
  final String level;       // CRITIQUE, MODERE, ou MINEUR
  final String label;       // ÉLEVÉ, MOYEN, ou FAIBLE
  final String projectName; // Nom du projet associé (venant de la relation Laravel)
  final DateTime updatedAt; // Date de dernière mise à jour
  final bool isArchived;    // État du risque (réglé ou non)

  RiskModel({
    required this.id,
    required this.title,
    required this.level,
    required this.label,
    required this.projectName,
    required this.updatedAt,
    this.isArchived = false,
  });

  /// Factory pour transformer le JSON de l'API Laravel en objet RiskModel
  factory RiskModel.fromJson(Map<String, dynamic> json) {
    return RiskModel(
      id: json['id'],
      title: json['title'] ?? 'Sans titre',
      level: json['level'] ?? 'MINEUR',
      label: json['label'] ?? 'FAIBLE',
      // On récupère le nom du projet dans l'objet imbriqué 'project' renvoyé par Laravel
      projectName: json['project'] != null ? json['project']['nom'] : 'Projet inconnu',
      updatedAt: DateTime.parse(json['updated_at']),
      isArchived: json['is_archived'] == 1 || json['is_archived'] == true,
    );
  }

  /// Helper pour obtenir la couleur thématique selon le niveau de sévérité
  Color get color {
    switch (level) {
      case 'CRITIQUE':
        return const Color(0xFFE74C3C); // Rouge SNGP
      case 'MODERE':
        return const Color(0xFFF39C12); // Orange SNGP
      case 'MINEUR':
        return const Color(0xFF3498DB); // Bleu SNGP
      default:
        return Colors.grey;
    }
  }

  /// Helper pour obtenir l'icône associée au niveau
  IconData get icon {
    switch (level) {
      case 'CRITIQUE':
        return Icons.report_problem_rounded;
      case 'MODERE':
        return Icons.warning_amber_rounded;
      default:
        return Icons.info_outline_rounded;
    }
  }
}