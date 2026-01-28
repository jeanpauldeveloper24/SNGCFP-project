import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MarketTracking extends StatelessWidget {
  const MarketTracking({super.key});

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Gestion des Appels d'Offres & Marchés",
          style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: const Color(0xFF1B4F72)),
        ),
        const SizedBox(height: 20),
        Expanded(
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: Colors.black12),
            ),
            child: ListView(
              children: [
                _buildMarketHeader(),
                _buildMarketRow("A0-001/2026", "Bitumage Route Nord", "Publié", Colors.blue),
                _buildMarketRow("A0-042/2025", "Fourniture Transformateurs", "Évaluation", Colors.orange),
                _buildMarketRow("A0-015/2025", "Construction Dispensaire", "Attribué", Colors.green),
                _buildMarketRow("A0-088/2025", "Étude Impact Environnement", "Annulé", Colors.red),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildMarketHeader() {
    return Container(
      padding: const EdgeInsets.all(15),
      color: Colors.grey[100],
      child: const Row(
        children: [
          Expanded(flex: 2, child: Text("N° DOSSIER", style: TextStyle(fontWeight: FontWeight.bold))),
          Expanded(flex: 4, child: Text("OBJET DU MARCHÉ", style: TextStyle(fontWeight: FontWeight.bold))),
          Expanded(flex: 2, child: Text("STATUT", style: TextStyle(fontWeight: FontWeight.bold))),
        ],
      ),
    );
  }

  Widget _buildMarketRow(String code, String label, String status, Color color) {
    return Container(
      padding: const EdgeInsets.all(15),
      decoration: const BoxDecoration(border: Border(bottom: BorderSide(color: Colors.black12))),
      child: Row(
        children: [
          Expanded(flex: 2, child: Text(code, style: const TextStyle(fontSize: 13))),
          Expanded(flex: 4, child: Text(label, style: const TextStyle(fontWeight: FontWeight.w500))),
          Expanded(
            flex: 2, 
            child: Container(
              padding: const EdgeInsets.symmetric(vertical: 4, horizontal: 8),
              decoration: BoxDecoration(color: color.withOpacity(0.1), borderRadius: BorderRadius.circular(4)),
              child: Text(status, style: TextStyle(color: color, fontSize: 11, fontWeight: FontWeight.bold), textAlign: TextAlign.center),
            )
          ),
        ],
      ),
    );
  }
}