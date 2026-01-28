import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Audit extends StatefulWidget {
  const Audit({super.key});

  @override
  State<Audit> createState() => _AuditState();
}

class _AuditState extends State<Audit> {
  final Color primaryBlue = const Color(0xFF1B4F72);

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Vérification de Conformité Financière",
          style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue),
        ),
        const SizedBox(height: 20),
        Expanded(
          child: ListView(
            children: [
              _buildAuditTask("Vérification des pièces justificatives - Lot 4", "En cours", Colors.orange),
              _buildAuditTask("Audit de conformité passation de marché", "Validé", Colors.green),
              _buildAuditTask("Examen des écarts budgétaires Q4 2025", "À réviser", Colors.red),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildAuditTask(String title, String status, Color color) {
    return Container(
      margin: const EdgeInsets.only(bottom: 15),
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(10),
        border: Border.all(color: Colors.black12),
      ),
      child: Row(
        children: [
          CircleAvatar(backgroundColor: color.withOpacity(0.1), child: Icon(Icons.fact_check, color: color)),
          const SizedBox(width: 15),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
                Text("Dernière modification par l'expert le 20/01/2026", style: TextStyle(fontSize: 11, color: Colors.grey[500])),
              ],
            ),
          ),
          Text(status, style: TextStyle(color: color, fontWeight: FontWeight.bold, fontSize: 12)),
        ],
      ),
    );
  }
}