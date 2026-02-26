import 'package:flutter/material.dart';

/// Modèle de données pour une Demande de Décaissement (DRF/DPD)
/// Conformément aux exigences de reporting financier de la BAD.
class ConventionData {
  final String id;
  final String ref;       // N° de la demande (ex: DRF-001)
  final String type;      // DRF ou DPD
  final String marcheRef; // Référence du marché lié pour la piste d'audit
  final String montant;   // Montant en FCFA
  final String statut;    // Brouillon, En cours, Approuvé, Rejeté
  final Color color;      // Couleur associée au statut
  final DateTime date;    // Date de création de la demande

  ConventionData({
    required this.id,
    required this.ref,
    required this.type,
    required this.marcheRef,
    required this.montant,
    required this.statut,
    required this.color,
    required this.date,
  });
}

/// Données de test (Mock Data) pour la Direction Nationale
class ConventionMock {
  static List<ConventionData> getInitialData() {
    return [
      ConventionData(
        id: "1",
        ref: "DRF-008",
        type: "DRF",
        marcheRef: "M002/26",
        montant: "250 000 000",
        statut: "Approuvé",
        color: Colors.green,
        date: DateTime(2026, 01, 15),
      ),
      ConventionData(
        id: "2",
        ref: "DPD-012",
        type: "DPD",
        marcheRef: "M001/26",
        montant: "45 000 000",
        statut: "En cours",
        color: Colors.orange,
        date: DateTime(2026, 02, 01),
      ),
      ConventionData(
        id: "3",
        ref: "DRF-009",
        type: "DRF",
        marcheRef: "M003/26",
        montant: "150 000 000",
        statut: "Brouillon",
        color: Colors.grey,
        date: DateTime(2026, 02, 10),
      ),
    ];
  }

  /// Calcul du taux de décaissement global (KPI)
  static double calculateDisbursementRate(double totalBudget, double disbursedAmount) {
    if (totalBudget == 0) return 0.0;
    return (disbursedAmount / totalBudget);
  }
}