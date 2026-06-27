import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MarcheScreen extends StatefulWidget {
  const MarcheScreen({super.key});

  @override
  State<MarcheScreen> createState() => _MarcheScreenState();
}

class _MarcheScreenState extends State<MarcheScreen> {
  // Données de simulation basées rigoureusement sur ton schéma de base de données
  final List<Map<String, dynamic>> _marches = [
    {
      "objet": "Fourniture de serveurs et déploiement de l'infrastructure réseau centralisée",
      "projet_module": "Module 3 : Digitalisation & Audit",
      "montant": "85 000 000",
      "status": "attribue",
      "user_role": "prestataire",
      "lancement_date": "10/01/2026",
      "attribution_date": "15/02/2026",
    },
    {
      "objet": "Construction de 3 centres de santé de premier contact (Zone Nord)",
      "projet_module": "Module 1 : Infrastructures Sociales",
      "montant": "620 000 000",
      "status": "en_cours_attribution",
      "user_role": "prestataire",
      "lancement_date": "01/03/2026",
      "attribution_date": "En attente",
    },
    {
      "objet": "Audit comptable et financier externe indépendant - Exercice 2026",
      "projet_module": "Module 5 : Gouvernance",
      "montant": "45 000 000",
      "status": "non_attribue",
      "user_role": "prestataire",
      "lancement_date": "15/05/2026",
      "attribution_date": "—",
    }
  ];

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color errorRed = const Color(0xFFE74C3C);
  final Color textDark = const Color(0xFF1E1E2D);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F6F9),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 24),
            _buildStatsOverview(),
            const SizedBox(height: 24),
            Expanded(
              child: Container(
                width: double.infinity,
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10)],
                  border: Border.all(color: Colors.grey.withOpacity(0.1)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _buildTableToolbar(),
                    Expanded(
                      child: SingleChildScrollView(
                        scrollDirection: Axis.vertical,
                        child: SingleChildScrollView(
                          scrollDirection: Axis.horizontal,
                          child: Container(
                            constraints: BoxConstraints(minWidth: MediaQuery.of(context).size.width - 350),
                            child: DataTable(
                              headingRowColor: MaterialStateProperty.all(const Color(0xFFF8F9FA)),
                              dataRowMaxHeight: 70, // Légèrement plus haut pour contenir l'objet du marché
                              columns: _buildTableColumns(),
                              rows: _marches.map((marche) => _buildMarcheRow(marche)).toList(),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Registre des Marchés & Contrats",
          style: GoogleFonts.montserrat(fontSize: 26, fontWeight: FontWeight.bold, color: textDark),
        ),
        const SizedBox(height: 4),
        Text(
          "Suivi des plans de passation des marchés, états d'attribution et engagements contractuels",
          style: GoogleFonts.inter(fontSize: 13, color: Colors.grey[600]),
        ),
      ],
    );
  }

  Widget _buildStatsOverview() {
    return Row(
      children: [
        _buildStatCard("Marchés Attribués", "1", Icons.gavel_rounded, Colors.green),
        const SizedBox(width: 16),
        _buildStatCard("En Cours d'Attribution", "1", Icons.hourglass_bottom_rounded, Colors.orange),
        const SizedBox(width: 16),
        _buildStatCard("Non Attribués / Lancés", "1", Icons.campaign_rounded, primaryBlue),
      ],
    );
  }

  Widget _buildStatCard(String title, String count, IconData icon, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(8),
          border: Border(left: BorderSide(color: color, width: 4)),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.01), blurRadius: 6)],
        ),
        child: Row(
          children: [
            Icon(icon, color: color, size: 28),
            const SizedBox(width: 16),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: GoogleFonts.inter(fontSize: 12, color: Colors.grey, fontWeight: FontWeight.w500)),
                const SizedBox(height: 2),
                Text(count, style: GoogleFonts.inter(fontSize: 18, fontWeight: FontWeight.bold, color: textDark)),
              ],
            )
          ],
        ),
      ),
    );
  }

  Widget _buildTableToolbar() {
    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            "Liste générale des appels d'offres",
            style: GoogleFonts.montserrat(fontSize: 15, fontWeight: FontWeight.bold, color: textDark),
          ),
          OutlinedButton.icon(
            onPressed: () {},
            icon: Icon(Icons.download_rounded, size: 16, color: primaryBlue),
            label: Text("Exporter le PPM (Excel)", style: TextStyle(color: primaryBlue)),
            style: OutlinedButton.styleFrom(
              side: BorderSide(color: primaryBlue.withOpacity(0.4)),
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            ),
          )
        ],
      ),
    );
  }

  List<DataColumn> _buildTableColumns() {
    return [
      DataColumn(label: Text('Objet du Marché', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Module Projet', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Montant Estimé / Alloué', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Statut Attribution', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Date Lancement', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      DataColumn(label: Text('Date Attribution', style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
    ];
  }

  DataRow _buildMarcheRow(Map<String, dynamic> marche) {
    return DataRow(cells: [
      // Objet du marché (Gestion propre des longs textes sur Desktop)
      DataCell(Container(
        width: 300,
        padding: const EdgeInsets.symmetric(vertical: 8),
        child: Text(
          marche["objet"],
          style: GoogleFonts.inter(fontSize: 13, fontWeight: FontWeight.w500, color: textDark),
          maxLines: 2,
          overflow: TextOverflow.ellipsis,
        ),
      )),
      
      DataCell(Text(marche["projet_module"], style: GoogleFonts.inter(fontSize: 12, color: Colors.grey[700]))),
      
      DataCell(Text("${marche["montant"]} FCFA", style: GoogleFonts.inter(fontWeight: FontWeight.bold, fontSize: 13))),
      
      // Statut : attribue, non_attribue, en_cours_attribution
      DataCell(_buildStatusBadge(marche["status"])),
      
      DataCell(Text(marche["lancement_date"], style: GoogleFonts.inter(fontSize: 12))),
      
      DataCell(Text(
        marche["attribution_date"], 
        style: GoogleFonts.inter(
          fontSize: 12, 
          fontWeight: marche["status"] == 'attribue' ? FontWeight.bold : FontWeight.normal,
          color: marche["status"] == 'attribue' ? Colors.green : Colors.grey
        )
      )),
    ]);
  }

  Widget _buildStatusBadge(String statusValue) {
    Color badgeColor;
    String label;

    switch (statusValue) {
      case 'attribue':
        badgeColor = Colors.green;
        label = "ATTRIBUÉ";
        break;
      case 'en_cours_attribution':
        badgeColor = Colors.orange;
        label = "EN COURS D'ATTRIBUTION";
        break;
      case 'non_attribue':
        badgeColor = primaryBlue;
        label = "NON ATTRIBUÉ";
        break;
      default:
        badgeColor = Colors.grey;
        label = statusValue.toUpperCase();
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
      decoration: BoxDecoration(
        color: badgeColor.withOpacity(0.1),
        borderRadius: BorderRadius.circular(4),
        border: Border.all(color: badgeColor.withOpacity(0.3), width: 1),
      ),
      child: Text(
        label,
        style: GoogleFonts.inter(color: badgeColor, fontSize: 10, fontWeight: FontWeight.bold, letterSpacing: 0.3),
      ),
    );
  }
}