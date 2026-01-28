import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Contrat extends StatelessWidget {
  const Contrat({super.key});

  final Color primaryBlue = const Color(0xFF1B4F72);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildContractHeader(),
          const SizedBox(height: 25),
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Expanded(flex: 3, child: _buildContractDetails()),
              const SizedBox(width: 20),
              Expanded(flex: 2, child: _buildAvenantsSection()),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildContractHeader() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: primaryBlue,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text("Marché N° BAD/CI/2026/042",
                  style: GoogleFonts.inter(color: Colors.white70, fontSize: 14)),
              const SizedBox(height: 5),
              Text("Construction du Pont de Cocody - Phase 2",
                  style: GoogleFonts.montserrat(
                      color: Colors.white,
                      fontSize: 20,
                      fontWeight: FontWeight.bold)),
            ],
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
                color: Colors.green, borderRadius: BorderRadius.circular(20)),
            child: const Text("ACTIF",
                style: TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                    fontSize: 12)),
          )
        ],
      ),
    );
  }

  Widget _buildContractDetails() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.black12),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _sectionTitle("Informations Générales"),
          const Divider(),
          _infoRow("Maître d'Ouvrage", "Ministère de l'Équipement / BAD"),
          _infoRow("Date de Signature", "15 Janvier 2025"),
          _infoRow("Délai d'Exécution", "24 Mois"),
          _infoRow("Montant Initial", "15 450 000 000 FCFA"),
          const SizedBox(height: 20),
          _sectionTitle("Clauses Particulières"),
          const SizedBox(height: 10),
          _clauseItem("Pénalités de retard : 1/2000ème du montant par jour."),
          _clauseItem("Retenue de garantie : 5% sur chaque décompte."),
          _clauseItem("Avance de démarrage : 20% (Cautionnée)."),
        ],
      ),
    );
  }

  Widget _buildAvenantsSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _sectionTitle("Avenants & Modifications"),
        const SizedBox(height: 10),
        _avenantCard("Avenant N°1", "+ 250M FCFA", "Travaux imprévus (Sols)", "Validé"),
        _avenantCard("Avenant N°2", "0 FCFA", "Prolongation 3 mois", "En cours"),
      ],
    );
  }

  Widget _infoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(label, style: const TextStyle(color: Colors.grey)),
          Text(value, style: const TextStyle(fontWeight: FontWeight.bold)),
        ],
      ),
    );
  }

  Widget _avenantCard(String title, String cost, String desc, String status) {
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(
          color: Colors.grey[50],
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.black12)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
              Text(cost, style: TextStyle(color: primaryBlue, fontWeight: FontWeight.bold, fontSize: 12)),
            ],
          ),
          const SizedBox(height: 5),
          Text(desc, style: const TextStyle(fontSize: 12, color: Colors.grey)),
          const SizedBox(height: 5),
          Text(status, style: const TextStyle(fontSize: 10, fontStyle: FontStyle.italic, color: Colors.orange)),
        ],
      ),
    );
  }

  Widget _clauseItem(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        children: [
          const Icon(Icons.check_circle_outline, size: 16, color: Colors.green),
          const SizedBox(width: 10),
          Expanded(child: Text(text, style: const TextStyle(fontSize: 13))),
        ],
      ),
    );
  }

  Widget _sectionTitle(String title) {
    return Text(title,
        style: GoogleFonts.montserrat(
            fontWeight: FontWeight.bold, fontSize: 16, color: primaryBlue));
  }
}