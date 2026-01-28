import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class AlertsRisks extends StatelessWidget {
  const AlertsRisks({super.key});

  final Color primaryBlue = const Color(0xFF1B4F72);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "Tableau de Suivi des Risques",
            style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue),
          ),
          const SizedBox(height: 20),
          
          // Section Risques Critiques
          _buildCategoryHeader("CRITIQUE", Colors.red),
          _buildRiskItem("Retard décaissement Tranche 2 - Projet Pont Abidjan", "ÉLEVÉ", Colors.red),
          _buildRiskItem("Dépassement de budget matériel (Acier)", "CRITIQUE", Colors.red),
          
          const SizedBox(height: 20),
          
          // Section Risques Modérés
          _buildCategoryHeader("MODÉRÉ", Colors.orange),
          _buildRiskItem("Indisponibilité expert technique local", "MOYEN", Colors.orange),
          _buildRiskItem("Risque météo (Saison des pluies)", "MODÉRÉ", Colors.orange),
          
          const SizedBox(height: 20),
          
          // Section Info/Faible
          _buildCategoryHeader("MINEUR", Colors.blue),
          _buildRiskItem("Mise à jour logiciel de saisie", "FAIBLE", Colors.blue),
        ],
      ),
    );
  }

  Widget _buildCategoryHeader(String title, Color color) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Row(
        children: [
          Icon(Icons.label_important_outline, color: color, size: 18),
          const SizedBox(width: 8),
          Text(
            title,
            style: GoogleFonts.inter(fontWeight: FontWeight.bold, color: color, letterSpacing: 1.2, fontSize: 12),
          ),
        ],
      ),
    );
  }

  // Voici ton code complété et fonctionnel
  Widget _buildRiskItem(String title, String level, Color color) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        border: Border(left: BorderSide(color: color, width: 6)),
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.03), blurRadius: 5, offset: const Offset(0, 2))
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: GoogleFonts.inter(fontWeight: FontWeight.w600, fontSize: 14)),
                const SizedBox(height: 4),
                Text("Dernière analyse : il y a 2 heures", style: TextStyle(fontSize: 11, color: Colors.grey[500])),
              ],
            ),
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: color,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Text(
              level,
              style: const TextStyle(color: Colors.white, fontSize: 10, fontWeight: FontWeight.bold),
            ),
          )
        ],
      ),
    );
  }
}